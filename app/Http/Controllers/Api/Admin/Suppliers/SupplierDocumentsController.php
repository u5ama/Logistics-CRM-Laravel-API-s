<?php

namespace App\Http\Controllers\Api\Admin\Suppliers;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierDocumentsResource;
use App\Models\SupplierDocuments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Suppliers Document
     *
     * Check that the Suppliers Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Suppliers Documents added based on specific supplier ID!.
     *
     */

    public function index(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $documents = SupplierDocuments::where('supplier_id', $supplier_id)->get();
        $documents = SupplierDocumentsResource::collection($documents);

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
     * Add Supplier Document
     *
     * Check that the Add New Supplier Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Document added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'supplier_id' => 'required',
                'title' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/supplier/Documents');
                $name = $file->getClientOriginalName();
            }

            $document = SupplierDocuments::create([
                'supplier_id' => $request->supplier_id,
                'title' => $request->title,
                'uploaded_file' => $path,
            ]);

            $document = new SupplierDocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Supplier Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_documents_store','message'=>$message];
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
     * Show Supplier Document
     *
     * Check that the Show Supplier Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Document object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $document = SupplierDocuments::where('id', $request->id)->first();
        if ($document)
        {
            $document = new SupplierDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Supplier Document found!',
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
     * Delete Supplier Document
     *
     * Check that the Delete Supplier Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $document = SupplierDocuments::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('Supplier Document Deleted.', Auth::user()->id);
                $document->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Supplier Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_documents_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
