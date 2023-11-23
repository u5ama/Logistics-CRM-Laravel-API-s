<?php

namespace App\Http\Controllers\Api\Admin\Suppliers;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierItemsResource;
use App\Models\SupplierItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Suppliers Item
     *
     * Check that the Suppliers Items is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Suppliers Items added based on specific supplier ID!.
     *
     */

    public function index(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $documents = SupplierItems::where('supplier_id', $supplier_id)->get();
        $documents = SupplierItemsResource::collection($documents);

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
     * Add Supplier Item
     *
     * Check that the Add New Supplier Item is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Item added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'supplierId' => 'required',
                'item_code' => 'required',
                'item_description' => 'required',
                'site' => 'required',
                'unit_price' => 'required',
                'gst_incl' => 'required',
                'UOM' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $supplier = new SupplierItems();
            $supplier->supplier_id = $request->supplierId;
            $supplier->item_code = $request->item_code;
            $supplier->item_description = $request->item_description;
            $supplier->site = $request->site;
            $supplier->unit_price = $request->unit_price;
            $supplier->gst_incl = $request->gst_incl;
            $supplier->UOM = $request->UOM;
            $supplier->save();

            $supplier = new SupplierItemsResource($supplier);

            return response()->json([
                'success' => true,
                'message' => 'Supplier Item created successfully!',
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_items_store','message'=>$message];
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
     * Show Supplier Item
     *
     * Check that the Show Supplier Item is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Item object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $supplier = SupplierItems::where('id', $request->id)->first();
        if ($supplier)
        {
            $supplier = new SupplierItemsResource($supplier);
            return response()->json([
                'success' => true,
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Supplier Item found!',
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
     *
     */

    /**
     * Update Supplier Item
     *
     * Check that the Update Supplier Item is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Item updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try{
            $validator_array = [
                'supplierId' => 'required',
                'item_code' => 'required',
                'item_description' => 'required',
                'site' => 'required',
                'unit_price' => 'required',
                'gst_incl' => 'required',
                'UOM' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $supplier = SupplierItems::where('id',$id)->first();
            $supplier->supplier_id = $request->supplierId;
            $supplier->item_code = $request->item_code;
            $supplier->item_description = $request->item_description;
            $supplier->site = $request->site;
            $supplier->unit_price = $request->unit_price;
            $supplier->gst_incl = $request->gst_incl;
            $supplier->UOM = $request->UOM;
            $supplier->save();

            $supplier = new SupplierItemsResource($supplier);

            return response()->json([
                'success' => true,
                'message' => 'Supplier Item updated successfully!',
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_items_update','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     *
     */

    /**
     * Delete Supplier Item
     *
     * Check that the Delete Supplier Item is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $supplier = SupplierItems::findorFail($id);
            if ($supplier) {

                LogActivity::addToLog('Supplier Item Deleted.', Auth::user()->id);
                $supplier->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Supplier Item deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_item_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
