<?php

namespace App\Http\Controllers\Api\Admin\MYOB;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\MYOBConnection;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MYOBController extends Controller
{
    /**
     * Handle the redirect URL after authentication with MYOB.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws GuzzleException
     */
    public function redirectUrl(Request $request)
    {
        try {
            $code = $request->code;
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ];
            $client = new \GuzzleHttp\Client([
                'headers' => $headers
            ]);

            $request = $client->post('https://secure.myob.com/oauth2/v1/authorize/',  [
                'form_params' => [
                    'client_id' => env('MYOB_CLIENT_ID'),
                    'client_secret' => env('MYOB_CLIENT_SECRET'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => env('MYOB_REDIRECT_URL'),
                ]
            ]);
            $contents = json_decode($request->getBody()->getContents());
            MYOBConnection::updateOrCreate([
                'id' => 1
            ],[
                'token_type' => $contents->token_type,
                'expires_in' => $contents->expires_in,
                'access_token' => $contents->access_token,
                'refresh_token' => $contents->refresh_token,
                'connection_status' => 'active',
            ]);
            return view('thanks');
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'myob_redirect_url','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Refresh the access token for MYOB.
     *
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function refresh_token()
    {
        try {
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ];
            $client = new \GuzzleHttp\Client([
                'headers' => $headers
            ]);
            $connection = MYOBConnection::where('id',1)->first();
            $request = $client->post('https://secure.myob.com/oauth2/v1/authorize/',  [
                'form_params' => [
                    'client_id' => env('MYOB_CLIENT_ID'),
                    'client_secret' => env('MYOB_CLIENT_SECRET'),
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $connection->refresh_token,
                ]
            ]);
            $contents = json_decode($request->getBody()->getContents());
            MYOBConnection::updateOrCreate([
                'id' => 1
            ],[
                'token_type' => $contents->token_type,
                'expires_in' => $contents->expires_in,
                'access_token' => $contents->access_token,
                'refresh_token' => $contents->refresh_token,
                'connection_status' => 'active',
            ]);
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'myob_refresh_token','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Get the connection status for MYOB.
     *
     * @return JsonResponse
     */
    public function getConnectionStatus()
    {
        try {
            $settings = MYOBConnection::where('id', 1)->first();
            if ($settings){
                $settings->connection_type = 'myob';
                return response()->json([
                    'success' => true,
                    'data' => $settings,
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'No Settings found!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'myob_connection_status','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Destroy the MYOB connection by setting the status to inactive.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $myob = MYOBConnection::where('id',$id)->update([
                'connection_status' => 'inactive',
            ]);
            if ($myob) {
                LogActivity::addToLog('MYOB Disconnected.', Auth::user()->id);

                return response()->json([
                    'success' => true,
                    'message' => 'MYOB Disconnected successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'myob_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
