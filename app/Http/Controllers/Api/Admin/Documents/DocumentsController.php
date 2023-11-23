<?php

namespace App\Http\Controllers\Api\Admin\Documents;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentsResource;
use App\Models\Documents;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All User Documents
     *
     * Check that the User Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all documents added by a user!.
     *
     */

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $documents = Documents::where('user_id', $user_id)->get();
        $documents = DocumentsResource::collection($documents);
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
     * Add User Document
     *
     * Check that the Add User Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be documents added by a user with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'user_id' => 'required',
                'title' => 'required',
                'document_type' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/documents');
                $name = $file->getClientOriginalName();
            }
            $document = Documents::create([
                'user_id' => $request->user_id,
                'title' => $request->title,
                'document_type' => $request->document_type,
                'uploaded_file' => $path,
            ]);

            $document = new DocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'documents_store','message'=>$message];
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
     * Show Document
     *
     * Check that the Show Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Document object for a specific id sent by User!.
     */

    public function show(Request $request)
    {
        $document = Documents::where('id', $request->id)->first();
        if ($document)
        {
            $document = new DocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Document found!',
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
     */

    /**
     * Delete Document
     *
     * Check that the Delete User Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     */

    public function destroy($id)
    {
        try {
            $document = Documents::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('User Document Deleted.', Auth::user()->id);
                $document->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'document_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
