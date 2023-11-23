<?php

namespace App\Http\Controllers\Api\Admin\Quotes;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuoteDocumentsResource;
use App\Models\QuoteDocuments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuoteDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Quote Documents
     *
     * Check that the Quote Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Quote documents added by a user!.
     *
     */

    public function index(Request $request)
    {
        $quote_id = $request->quote_id;
        $documents = QuoteDocuments::where('quote_id', $quote_id)->get();
        $documents = QuoteDocumentsResource::collection($documents);

        return response()->json([
            'success' => true,
            'data' => $documents,
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
     * Add Quote Document
     *
     * Check that the Add Quote Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote documents added by a user with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'quote_id' => 'required',
                'title' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/quotes/Documents');
                $name = $file->getClientOriginalName();
            }

            $document = QuoteDocuments::create([
                'quote_id' => $request->quote_id,
                'title' => $request->title,
                'uploaded_file' => $path,
            ]);

            $document = new QuoteDocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Quote Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_documents_store','message'=>$message];
            $errors =[$error];
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
     * Show Quote Document
     *
     * Check that the Show Quote Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Quote Document object for a specific id sent by User!.
     */

    public function show(Request $request)
    {
        $document = QuoteDocuments::where('id', $request->id)->first();
        if ($document)
        {
            $document = new QuoteDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Quote Document found!',
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
     * @return JsonResponse|void
     *
     */

    /**
     * Delete Quote Document
     *
     * Check that the Delete Quote Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     */

    public function destroy($id)
    {
        try {
            $document = QuoteDocuments::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('Quote Document Deleted.', Auth::user()->id);
                $document->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Quote Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_documents_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
