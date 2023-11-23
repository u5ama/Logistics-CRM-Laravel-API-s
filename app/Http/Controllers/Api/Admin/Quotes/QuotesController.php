<?php

namespace App\Http\Controllers\Api\Admin\Quotes;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuotesResource;
use App\Mail\QuoteMail;
use App\Models\Jobs;
use App\Models\JobsAssets;
use App\Models\QuoteAssets;
use App\Models\QuoteDocuments;
use App\Models\QuoteItems;
use App\Models\Quotes;
use App\Models\QuoteSettings;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function Webmozart\Assert\Tests\StaticAnalysis\allAlnum;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Quotes
     *
     * Check that the Quotes is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Quotes added!.
     *
     *
     */

    public function index()
    {
        $quotes = Quotes::with('client','quoteItems','job','sales', 'quoteAssets')->get();
        $quotes = QuotesResource::collection($quotes);

        return response()->json([
            'success' => true,
            'data' => $quotes,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Add Quote
     *
     * Check that the Add New Quote is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'client_id' => 'required',
                'items' => 'required',
                'quote_name' => 'required',
                'location' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $quote = new Quotes();
            $quote->client_id = $request->client_id;
            $quote->job_id = $request->job_id;
            $quote->representative_id = $request->representative_id;
            $quote->quote_name = $request->quote_name;
            $quote->location = $request->location;
            $quote->quote_entity = $request->quote_entity;
            $quote->terms_condition_id = $request->terms_condition_id;
            $quote->quote_footer_id = $request->quote_footer_id;
            $quote->terms_condition_text = $request->terms_condition_text;
            $quote->quote_footer_text = $request->quote_footer_text;
            $quote->material_type = $request->material_type;
            $quote->save();

            if ($request->assets){
                $assets = explode(',',$request->assets);
                if(count($assets)>0){
                    foreach ($assets as $a){
                        $check = new QuoteAssets();
                        $check->quote_id  = $quote->id ;
                        $check->asset_id = $a;
                        $check->save();
                    }
                }
            }

            $items = $request->items;
            if (count($items)>0){
                foreach ($items as $item){
                    $quoteItem = new QuoteItems();
                    $quoteItem->quote_id = $quote->id;
                    $quoteItem->title = $item['title'];
                    $quoteItem->description = $item['description'];
                    $quoteItem->quote_price = $item['quote_price'];
                    $quoteItem->save();
                }
            }

            if ($files = $request->file('files')) {
                foreach ($files as $file) {
                    $path = $file->store('public/quotes/Documents');
                    $name = $file->getClientOriginalName();

                    QuoteDocuments::create([
                        'quote_id' => $quote->id,
                        'title' => $name,
                        'uploaded_file' => $path,
                    ]);
                }
            }

            $inv = Quotes::with('client','quoteItems','job','sales', 'quoteAssets')->where('id', $quote->id)->first();
            $quote = new QuotesResource($inv);

            return response()->json([
                'success' => true,
                'message' => 'Quote created successfully!',
                'data' => $quote,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_store','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Show Quote to create PDF
     *
     * Check that the Show Quote is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $quote = Quotes::with('client','quoteItems','job','sales', 'terms', 'footer', 'quoteAssets')->where('id', $request->id)->first();
        if ($quote)
        {
            $prof = UserProfile::where('user_id', $quote->client->id)->first();
            $quote->profile = $prof;

            $setting = QuoteSettings::where('id',1)->first();
            if ($setting){
                $quote->setting = $setting;
            }

            $pricing = [];
            if (count($quote->quoteItems)>0){
                foreach ($quote->quoteItems as $item){
                    $pricing[] = $item->quote_price;
                }
            }
            $total_price = array_sum($pricing);
            $quote->total_price = $total_price;

            $items = $quote->quoteItems;
            foreach ($items as $item){
                $item['quote_price_key_name'] = 'quote_price';
                $item['description_key_name'] = 'description';
                $item['title_key_name'] = 'title';
            }

            $quote = new QuotesResource($quote);

            return response()->json([
                'success' => true,
                'data' => $quote,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Quote found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function sendQuoteEmail(Request $request)
    {
        try {
            $quote = Quotes::with('client','quoteItems','job', 'terms', 'footer', 'quoteAssets')->where('id', $request->id)->first();
            if ($quote)
            {
                $quoteSetting = QuoteSettings::updateOrCreate(
                    ['quote_id'=> $request->id], [
                    'terms_conditions' => $request->terms_conditions,
                    'op_manager_name' => $request->op_manager_name,
                    'op_manager_email' => $request->op_manager_email,
                    'op_manager_phone' => $request->op_manager_phone,
                    'quote_note' => $request->quote_note,
                    'company_name' => $request->company_name,
                ]);
                if ($quoteSetting){
                    $quote->setting = $quoteSetting;
                }

                $pricing = [];
                if (count($quote->quoteItems)>0){
                    foreach ($quote->quoteItems as $item){
                        $pricing[] = $item->quote_price;
                    }
                }
                $total_price = array_sum($pricing);
                $quote->total_price = $total_price;

                $quote = new QuotesResource($quote);

                $documents = QuoteDocuments::where('quote_id',$quote->id)->get();
                $quote->documents = $documents;
            }
            $mailData = ['quote' => $quote];

//            Mail::to('u.web.dev.14@gmail.com')->send(new QuoteMail($mailData));
            $users_ids = explode(',',$request->user_ids);
            foreach ($users_ids as $user_id){
                $user = User::where('id', $user_id)->first();
                Mail::to($user->email)->send(new QuoteMail($mailData));
            }
            return response()->json([
                'success' => true,
                'message' => 'Quote Email Send successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_email','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */

    /**
     * Update Quote
     *
     * Check that the Update Quote is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try{
            $validator_array = [
                'client_id' => 'required',
                'items' => 'required',
                'quote_name' => 'required',
                'location' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $quote = Quotes::where('id',$id)->first();
            $quote->client_id = $request->client_id;
            $quote->job_id = $request->job_id;
            $quote->representative_id = $request->representative_id;
            $quote->quote_name = $request->quote_name;
            $quote->location = $request->location;
            $quote->quote_entity = $request->quote_entity;
            $quote->terms_condition_id = $request->terms_condition_id;
            $quote->quote_footer_id = $request->quote_footer_id;
            $quote->terms_condition_text = $request->terms_condition_text;
            $quote->quote_footer_text = $request->quote_footer_text;
            $quote->material_type = $request->material_type;
            $quote->save();

            QuoteAssets::where('quote_id', $quote->id)->delete();

            if ($request->assets){
                $assets = explode(',',$request->assets);
                if(count($assets)>0){
                    foreach ($assets as $a){
                        $check = new QuoteAssets();
                        $check->quote_id  = $quote->id ;
                        $check->asset_id = $a;
                        $check->save();
                    }
                }
            }

            QuoteItems::where('quote_id', $quote->id)->delete();

            $items = $request->items;
            if (count($items)>0){
                foreach ($items as $item){
                    $quoteItem = new QuoteItems();
                    $quoteItem->quote_id = $quote->id;
                    $quoteItem->title = $item['title'];
                    $quoteItem->description = $item['description'];
                    $quoteItem->quote_price = $item['quote_price'];
                    $quoteItem->save();
                }
            }

            $inv = Quotes::with('client','quoteItems','job', 'quoteAssets')->where('id', $quote->id)->first();
            $quote = new QuotesResource($inv);

            return response()->json([
                'success' => true,
                'message' => 'Quote updated successfully!',
                'data' => $quote,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_update','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */

    /**
     * Delete Quote
     *
     * Check that the Delete Quote is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $quote = Quotes::findorFail($id);
            if ($quote) {

                QuoteItems::where('quote_id', $quote->id)->delete();

                LogActivity::addToLog('Quote Deleted.', Auth::user()->id);
                $quote->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Quote deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * All SalesPersons
     *
     * Check that the SalesPersons is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all SalesPersons added!.
     *
     *
     */
    public function salesPersons()
    {
        try {
            $sales_persons = User::where(['user_type'=>'4', 'user_status' => 'active'])->get();
            return response()->json([
                'success' => true,
                'data' => $sales_persons,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_sales_person','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function acceptQuoteJob(Request $request)
    {
        try {
            $quote = Quotes::with( 'quoteAssets')->where('id', $request->id)->first();
            if($quote){
                $job = new Jobs();
                $job->job_title = $quote->quote_name;
                $job->job_location = $quote->location;
                $job->client_id = $quote->client_id;
                $job->save();

                if (count($quote->quoteAssets)>0){
                    foreach ($quote->quoteAssets as $a){
                        $asset = new JobsAssets();
                        $asset->job_id = $job->id;
                        $asset->asset_id = $a->asset_id;
                        $asset->save();
                    }
                }
            }
            $quote->quote_status = 'Accepted';
            $quote->job_id = $job->id;
            $quote->save();

            return response()->json([
                'success' => true,
                'data' => $quote,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_accept','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
