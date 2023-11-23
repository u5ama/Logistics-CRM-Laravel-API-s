<?php

namespace App\Http\Controllers\Api\Admin\Quotes;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\TermsConditionsResource;
use App\Models\TermsConditions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuotesTermsConditionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Quote Terms Conditions
     *
     * Check that the Quote Terms Conditions is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Quote Terms Conditions added!.
     *
     *
     */

    public function index(Request $request)
    {
        $termsConditions = TermsConditions::all();
        $termsConditions = TermsConditionsResource::collection($termsConditions);

        return response()->json([
            'success' => true,
            'data' => $termsConditions,
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
     * Add Quote Terms and Conditions
     *
     * Check that the Add Quote Terms and Conditions is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Terms and Conditions added with success message!.
     *
     */

    public function store(Request $request)
    {
        try {
            $validator_array = [
                'title' => 'required',
                'terms_conditions' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $terms = new TermsConditions();
            $terms->terms_conditions = $request->terms_conditions;
            $terms->title = $request->title;
            $terms->save();

            $terms = new TermsConditionsResource($terms);

            return response()->json([
                'success' => true,
                'message' => 'Quote Terms&Conditions Submitted successfully!',
                'data' => $terms,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_terms_store','message'=>$message];
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
        $terms = TermsConditions::where('id', $request->id)->first();
        if ($terms)
        {
            $terms = new TermsConditionsResource($terms);

            return response()->json([
                'success' => true,
                'data' => $terms,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Quote Terms found!',
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'title' => 'required',
                'terms_conditions' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $terms = TermsConditions::where('id', $id)->first();
            $terms->terms_conditions = $request->terms_conditions;
            $terms->title = $request->title;
            $terms->save();

            $terms = new TermsConditionsResource($terms);

            return response()->json([
                'success' => true,
                'message' => 'Quote Terms&Conditions Updated Successfully!',
                'data' => $terms,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_terms_update','message'=>$message];
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
    public function destroy($id)
    {
        try {
            $quote = TermsConditions::findorFail($id);
            if ($quote) {

                LogActivity::addToLog('Quote Terms Conditions Deleted.', Auth::user()->id);
                $quote->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Quote Terms Conditions deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_terms_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
