<?php

namespace App\Http\Controllers\Api\Admin\Invoicing;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllocatedInvoicesResource;
use App\Models\AllocatedInvoices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AllocatedInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Allocated Invoices
     *
     * Check that the Allocated Invoices is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Allocated Invoices added!.
     *
     *
     */

    public function index(Request $request)
    {
        $invoice_id = $request->invoiceId;
        $documents = AllocatedInvoices::with('subcontractor')->where('invoice_id', $invoice_id)->get();
        $documents = AllocatedInvoicesResource::collection($documents);
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
     * Add Allocated Invoice
     *
     * Check that the Add Allocated Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Allocated Invoice added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'invoice_id' => 'required',
                'subcontractor_id' => 'required',
                'amount' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:50000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/invoicing/allocatedInvoices');
                $name = $file->getClientOriginalName();
            }
            $document = AllocatedInvoices::create([
                'invoice_id' => $request->invoice_id,
                'subcontractor_id' => $request->subcontractor_id,
                'amount' => $request->amount,
                'uploaded_file' => $path,
            ]);
            $document = AllocatedInvoices::with('subcontractor')->where('id', $document->id)->get();
            $document = new AllocatedInvoicesResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Invoice Allocated created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'allocated_invoice_store','message'=>$message];
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
     * Show Allocated Invoice
     *
     * Check that the Show Allocated Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Allocated Invoice object for a specific id sent by User!.
     */

    public function show(Request $request)
    {
        $document = AllocatedInvoices::where('id', $request->id)->first();
        if ($document)
        {
            $document = new AllocatedInvoicesResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Job Document found!',
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
     * Delete Allocated Invoice
     *
     * Check that the Delete Allocated Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     */

    public function destroy($id)
    {
        try {
            $document = AllocatedInvoices::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('Allocated Invoice Deleted.', Auth::user()->id);
                $document->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Job Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'allocated_invoice_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
