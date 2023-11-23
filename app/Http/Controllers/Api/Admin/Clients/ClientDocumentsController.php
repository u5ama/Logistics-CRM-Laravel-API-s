<?php

namespace App\Http\Controllers\Api\Admin\Clients;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientDocumentsResource;
use App\Models\ClientDocuments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * All Client Documents
     *
     * Check that the Client Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all documents added for the Client!.
     *
     */
    public function index(Request $request)
    {
        $client_id = $request->client_id;
        $documents = ClientDocuments::where('client_id', $client_id)->get();
        $documents = ClientDocumentsResource::collection($documents);

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
     */
    /**
     * Add Client Document
     *
     * Check that the Add Client Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be documents added for the Client with success message!.
     *
     */
    public function store(Request $request)
    {
        try{
            $validator_array = [
                'client_id' => 'required',
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

            $document = ClientDocuments::create([
                'client_id' => $request->client_id,
                'title' => $request->title,
                'uploaded_file' => $path,
            ]);

            $document = new ClientDocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Client Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_documents_store','message'=>$message];
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
     * Show Document
     *
     * Check that the Show Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Document object for a specific id for the Client!.
     *
     */
    public function show(Request $request)
    {
        $document = ClientDocuments::where('id', $request->id)->first();
        if ($document)
        {
            $document = new ClientDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Client Document found!',
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
     * @return JsonResponse
     *
     */
    /**
     * Delete Document
     *
     * Check that the Delete Client Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */
    public function destroy($id)
    {
        try {
            $document = ClientDocuments::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('Client Document Deleted.', Auth::user()->id);
                $document->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Client Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_documents_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
