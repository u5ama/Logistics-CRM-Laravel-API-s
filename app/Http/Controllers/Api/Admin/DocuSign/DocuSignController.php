<?php

namespace App\Http\Controllers\Api\Admin\DocuSign;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\DocusignConnection;
use App\Models\DocusignDocument;
use App\Models\Quotes;
use App\Models\User;
use DocuSign\eSign\Api\EnvelopesApi;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Client\ApiClient;

class DocuSignController extends Controller
{

    /** hold config value */
    private $config;

    private $signer_client_id = 1000; # Used to indicate that the signer will use embedded

    /** Specific template arguments */
    private $args;


    public function index()
    {
        return view('docusign');
    }

    /**
     * Connect your application to docusign
     *
     * @return string
     */
    public function connectDocusign()
    {
        try {
            $params = [
                'response_type' => 'code',
                'scope' => 'extended+signature',
                'client_id' => env('DOCUSIGN_CLIENT_ID'),
                'state' => 'a39fh23hnf23',
                'redirect_uri' =>env('DOCUSIGN_REDIRECT'),
            ];
            $queryBuild = http_build_query($params);

            $url = "https://account-d.docusign.com/oauth/auth?";

            $botUrl = $url . $queryBuild;

            return redirect()->to($botUrl);
        }
        catch (Exception $e)
        {
            return redirect()->back()->with('error', 'Something Went wrong !');
        }
    }

    /**
     *
     * This function called when you auth your application with docusign
     *
     */
    public function callback(Request $request)
    {
        try{
            $code = $request->code;

            $client_id = env('DOCUSIGN_CLIENT_ID');
            $client_secret = env('DOCUSIGN_CLIENT_SECRET');
            $integrator_and_secret_key = "Basic " . utf8_decode(base64_encode("{$client_id}:{$client_secret}"));
            $headers = [
                "Authorization" => $integrator_and_secret_key,
                "Content-Type" => "application/x-www-form-urlencoded",
            ];
            $client = new Client(['headers' => $headers]);
            $request = $client->post('https://account-d.docusign.com/oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                ]
            ]);
            $result = json_decode($request->getBody()->getContents());
            DocusignConnection::updateorCreate([
                'id' => 1
            ],[
                'token_type' => $result->token_type,
                'expires_in' => $result->expires_in,
                'access_token' => $result->access_token,
                'refresh_token' => $result->refresh_token,
                'connection_status' => 'active',
            ]);
            return view('thanks');
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'docusign_redirect_url','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function refresh_token()
    {
        try {
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ];
            $client = new \GuzzleHttp\Client([
                'headers' => $headers
            ]);
            $connection = DocusignConnection::where('id',1)->first();
            $request = $client->post('https://account-d.docusign.com/oauth/token',  [
                'form_params' => [
                    'client_id' => env('DOCUSIGN_CLIENT_ID'),
                    'client_secret' => env('DOCUSIGN_CLIENT_SECRET'),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $connection->refresh_token,
                ]
            ]);
            $contents = json_decode($request->getBody()->getContents());
            DocusignConnection::updateorCreate([
                'id' => 1
            ],[
                'token_type' => $contents->token_type,
                'expires_in' => $contents->expires_in,
                'access_token' => $contents->access_token,
                'refresh_token' => $contents->refresh_token,
                'connection_status' => 'active',
            ]);
            return $contents->access_token;
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'docusign_refresh_token','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function getDocusignSettings()
    {
        try{
            $settings = DocusignConnection::where('id', 1)->first();
            if ($settings){
                $settings->connection_type = 'docusign';
                return response()->json([
                    'success' => true,
                    'data' => $settings,
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'No settings found!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'docusign_settings','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $myob = DocusignConnection::where('id',$id)->update([
                'connection_status' => 'inactive',
            ]);
            if ($myob) {
                LogActivity::addToLog('Docusign Disconnected.', Auth::user()->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Docusign Disconnected successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'docusign_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function uploadFileForSign(Request $request)
    {
        try{
            $validator_array = [
                'quoteId' => 'required',
                'upload_file' => 'required|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            if ($file = $request->file('upload_file')) {
                $extension = $file->getClientOriginalExtension();
                $name = Str::uuid()->toString();
                $filename = $name . '.' . $extension;
                $path = $file->storeAs('public/docusign/Documents', $filename);
            }
            $quote = Quotes::where('id', $request->quoteId)->first();
            $document = DocusignDocument::create([
                'quote_id' => $request->quoteId,
                'user_id' => $quote->client_id,
                'uploaded_file' => $path,
            ]);
            $user = User::where('id', $quote->client_id)->first();
            try {
                $this->signDocument($path, $user);
            }
            catch(\Exception $e)
            {
                $message = $e->getMessage();
                $error = ['field'=>'error','message'=>$message];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }
            return response()->json([
                'success' => true,
                'data' => $document,
                'message' => 'Docusign Document created successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'docusign_documents_store','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Write code on Method
     *
     */
    public function signDocument($path, $user)
    {
        try{
            $this->args = $this->getTemplateArgs();
            $args = $this->args;

            $envelope_args = $args["envelope_args"];

            /* Create the envelope request object */
            $envelope_definition = $this->makeEnvelopeFileObject($args["envelope_args"], $path, $user);
            $envelope_api = $this->getEnvelopeApi();

            $api_client = new \DocuSign\eSign\client\ApiClient($this->config);
            $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($api_client);
            $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
            $envelopeId = $results->getEnvelopeId();

            $authentication_method = 'None';
            $recipient_view_request = new \DocuSign\eSign\Model\RecipientViewRequest([
                'authentication_method' => $authentication_method,
                'client_user_id' => $envelope_args['signer_client_id'],
                'recipient_id' => '1',
                'return_url' => $envelope_args['ds_return_url'],
                'user_name' => $user->name, 'email' => $user->email
            ]);

            $results = $envelope_api->createRecipientView($args['account_id'], $envelopeId, $recipient_view_request);
            return redirect()->to($results['url']);

        } catch (Exception $e) {
            $message = $e->getMessage();
            $error = ['field'=>'docusign_documents_sign','message'=> $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }

    }

    /**
     * Write code on Method
     *
     */
    private function makeEnvelopeFileObject($args, $path, $user)
    {
        $docsFilePath = storage_path('app/' . $path);

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $contentBytes = file_get_contents($docsFilePath, false, stream_context_create($arrContextOptions));

        /* Create the document model */
        $document = new \DocuSign\eSign\Model\Document([
            'document_base64' => base64_encode($contentBytes),
            'name' => 'QuoteFile',
            'file_extension' => 'pdf',
            'document_id' => 1
        ]);

        /* Create the signer recipient model */
        $signer = new \DocuSign\eSign\Model\Signer([
            'email' => $user->email,
            'name' => $user->name,
            'recipient_id' => '1',
            'routing_order' => '1',
            'client_user_id' => $args['signer_client_id']
        ]);

        /* Create a signHere tab (field on the document) */
        $signHere = new \DocuSign\eSign\Model\SignHere([
            'anchor_string' => '/sn1/',
            'anchor_units' => 'pixels',
            'anchor_y_offset' => '10',
            'anchor_x_offset' => '20'
        ]);

        /* Create a signHere 2 tab (field on the document) */
        $signHere2 = new \DocuSign\eSign\Model\SignHere([
            'anchor_string' => '/sn2/',
            'anchor_units' => 'pixels',
            'anchor_y_offset' => '40',
            'anchor_x_offset' => '40'
        ]);
        $signer->settabs(new \DocuSign\eSign\Model\Tabs(['sign_here_tabs' => [$signHere, $signHere2]]));
        $envelopeDefinition = new \DocuSign\eSign\Model\EnvelopeDefinition([
            'email_subject' => "Please sign this Quote sent from Starbuck.com",
            'documents' => [$document],
            'recipients' => new \DocuSign\eSign\Model\Recipients(['signers' => [$signer]]),
            'status' => "sent",
        ]);
        return $envelopeDefinition;
    }

    /**
     * Write code on Method
     *
     */
    public function getEnvelopeApi(): EnvelopesApi
    {
        $this->config = new Configuration();
        $this->config->setHost($this->args['base_path']);
        $this->config->addDefaultHeader('Authorization', 'Bearer ' . $this->args['ds_access_token']);
        $this->apiClient = new ApiClient($this->config);
        return new EnvelopesApi($this->apiClient);
    }

    /**
     * Write code on Method
     *
     */
    private function getTemplateArgs()
    {
        return [
            'account_id' => env('DOCUSIGN_ACCOUNT_ID'),
            'base_path' => env('DOCUSIGN_BASE_URL'),
            'ds_access_token' => $this->refresh_token(),
            'envelope_args' => [
                'signer_client_id' => $this->signer_client_id,
                'ds_return_url' => route('docusign')
            ]
        ];
    }
}
