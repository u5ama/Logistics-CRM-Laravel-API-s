<?php

namespace App\Http\Controllers\Api\Admin\Asset\AssetDocuments;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetDocumentsResource;
use App\Models\AssetDocuments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Asset Documents
     *
     * Check that the Asset Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all documents added for the asset!.
     *
     */

    public function index(Request $request)
    {
        $asset_id = $request->asset_id;
        $documents = AssetDocuments::where('asset_id', $asset_id)->get();
        $documents = AssetDocumentsResource::collection($documents);
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
     * Add Asset Document
     *
     * Check that the Add Asset Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be documents added for the asset with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'asset_id' => 'required',
                'title' => 'required',
                'expiry' => 'required',
                'alert' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/asset/assetDocuments');
                $name = $file->getClientOriginalName();
            }

            $document = AssetDocuments::create([
                'asset_id' => $request->asset_id,
                'title' => $request->title,
                'expiry' => $request->expiry,
                'alert' => $request->alert,
                'uploaded_file' => $path,
            ]);

            $document = new AssetDocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Asset Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_documents_store','message'=>$message];
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
     * Show Document
     *
     * Check that the Show Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Document object for a specific id for the asset!.
     *
     */

    public function show(Request $request)
    {
        $document = AssetDocuments::where('id', $request->id)->first();
        if ($document)
        {
            $document = new AssetDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Asset Document found!',
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
     *
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
     * Check that the Delete Asset Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $document = AssetDocuments::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('Asset Document Deleted.', Auth::user()->id);
                $document->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Asset Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_documents_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
