<?php

namespace App\Http\Controllers\Api\Accounts\Quotes;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuotesResource;
use App\Models\Quotes;
use App\Models\QuoteSettings;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ClientQuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */
    /**
     * Get All client Quotes
     *
     * Check that the clients Quotes is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all clients quotes added!.
     *
     *
     */
    public function index()
    {
        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        $quotes = Quotes::with('client','quoteItems','job')->where('client_id', $user->id)->get();
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
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     *
     */
    /**
     * Show client quotes
     *
     * Check that the Show client quotes is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be client quotes object for a specific id!.
     *
     */
    public function show(Request $request)
    {
        $quote = Quotes::with('client','quoteItems','job','terms', 'footer')->where('id', $request->id)->first();

        if ($quote)
        {
            $prof = UserProfile::where('user_id', $quote->client->id)->first();
            $quote->profile = $prof;

            $setting = QuoteSettings::where('id',1)->first();
            $quote->setting = $setting;

            $quote->terms_conditions = isset($quote->terms) ? $quote->terms->terms_conditions: null;
            $quote->over_rate = isset($quote->footer) ? $quote->footer->description: null;

            $quote = new QuotesResource($quote);

            return response()->json([
                'success' => true,
                'data' => $quote,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Client Quote found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Approve client quote
     *
     * Check that the Show client quote is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be client quote approval message for a specific id!.
     *
     */
    public function approveQuote(Request $request)
    {
        try{
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);

            Quotes::where(['id'=> $request->id, 'client_id' => $user->id])->update([
                'quote_status' => 'Approved'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quote Approved successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'approve_quote','message'=>$message];
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
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
