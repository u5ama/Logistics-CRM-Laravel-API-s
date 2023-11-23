<?php

namespace App\Http\Controllers\Api\Admin\Quotes;

use App\Http\Controllers\Controller;
use App\Models\QuoteSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuotesSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Quote Settings
     *
     * Check that the Quote Settings is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Quote Settings added!.
     *
     *
     */

    public function index(Request $request)
    {
        $quoteSetting = QuoteSettings::where('quote_id',$request->quote_id)->first();

        return response()->json([
            'success' => true,
            'data' => $quoteSetting,
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
     *
     */

    /**
     * Add OR Update Quote Setting
     *
     * Check that the Add OR Update Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote Setting added with success message!.
     *
     */

    public function store(Request $request)
    {
        try {
            $validator_array = [
                'quote_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $quoteSetting = QuoteSettings::updateOrCreate(
                ['quote_id'=> $request->quote_id], [
                'terms_conditions' => $request->terms_conditions,
                'op_manager_name' => $request->op_manager_name,
                'op_manager_email' => $request->op_manager_email,
                'op_manager_phone' => $request->op_manager_phone,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Quote Settings successfully!',
                'data' => $quoteSetting,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_settings_store','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     *
     */
    /**
     * Show Quote Settings
     *
     * Check that the Show Quote Settings is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote Settings object for a specific id!.
     *
     */
    public function show(Request $request)
    {
        $quoteSetting = QuoteSettings::where('id', $request->id)->first();
        if ($quoteSetting)
        {
            return response()->json([
                'success' => true,
                'data' => $quoteSetting,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Quote Setting found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
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
