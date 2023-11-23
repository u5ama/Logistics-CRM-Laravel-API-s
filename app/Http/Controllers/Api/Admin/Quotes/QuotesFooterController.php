<?php

namespace App\Http\Controllers\Api\Admin\Quotes;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuotesFooterResource;
use App\Models\QuotesFooter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuotesFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Quote Footer
     *
     * Check that the Quote Footer is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Quote Footer added!.
     *
     *
     */

    public function index()
    {
        $footer = QuotesFooter::all();
        $footer = QuotesFooterResource::collection($footer);

        return response()->json([
            'success' => true,
            'data' => $footer,
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
     * Add Quote Footer
     *
     * Check that the Add Quote Terms and Conditions is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Footer added with success message!.
     *
     */

    public function store(Request $request)
    {
        try {
            $validator_array = [
                'title' => 'required',
                'description' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $footer = new QuotesFooter();
            $footer->description = $request->description;
            $footer->title = $request->title;
            $footer->save();

            $footer = new QuotesFooterResource($footer);

            return response()->json([
                'success' => true,
                'message' => 'Quote Footer Submitted successfully!',
                'data' => $footer,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_footer_store','message'=>$message];
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
     * Show Quote Footer
     *
     * Check that the Show Quote Footer is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote Footer object for a specific id!.
     *
     */
    public function show(Request $request)
    {
        $footer = QuotesFooter::where('id', $request->id)->first();
        if ($footer)
        {
            $footer = new QuotesFooterResource($footer);

            return response()->json([
                'success' => true,
                'data' => $footer,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Quote Footer found!',
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
                'description' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $footer = QuotesFooter::where('id', $id)->first();
            $footer->description = $request->description;
            $footer->title = $request->title;
            $footer->save();

            $footer = new QuotesFooterResource($footer);

            return response()->json([
                'success' => true,
                'message' => 'Quote Footer Updated Successfully!',
                'data' => $footer,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_footer_update','message'=>$message];
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
            $quote = QuotesFooter::findorFail($id);
            if ($quote) {

                LogActivity::addToLog('Quote Footer Deleted.', Auth::user()->id);
                $quote->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Quote Footer deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_footer_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
