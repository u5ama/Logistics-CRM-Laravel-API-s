<?php

namespace App\Http\Controllers\Api\Admin\Suppliers;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\SuppliersResource;
use App\Models\Suppliers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Suppliers
     *
     * Check that the Suppliers is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Suppliers added!.
     *
     *
     */
    public function index()
    {
        $suppliers = Suppliers::all();
        $suppliers = SuppliersResource::collection($suppliers);

        return response()->json([
            'success' => true,
            'data' => $suppliers,
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
     * Add Supplier
     *
     * Check that the Add New Supplier is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'abn' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $supplier = new Suppliers();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->abn = $request->abn;
            $supplier->save();

            $supplier = new SuppliersResource($supplier);

            return response()->json([
                'success' => true,
                'message' => 'Supplier created successfully!',
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_store','message'=>$message];
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
     * Show Supplier
     *
     * Check that the Show Supplier is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $supplier = Suppliers::where('id', $request->id)->first();
        if ($supplier)
        {
            $supplier = new SuppliersResource($supplier);
            return response()->json([
                'success' => true,
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Supplier found!',
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

    /**
     * Update Supplier
     *
     * Check that the Update Supplier is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'abn' => 'required'
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $supplier = Suppliers::where('id', $id)->first();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->abn = $request->abn;
            $supplier->save();

            $supplier = new SuppliersResource($supplier);

            return response()->json([
                'success' => true,
                'data' => $supplier,
                'message' => 'Supplier updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_update','message'=>$message];
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

    /**
     * Delete Supplier
     *
     * Check that the Delete Supplier is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $subcontractor = Suppliers::findorFail($id);
            if ($subcontractor) {

                LogActivity::addToLog('Supplier Deleted.', Auth::user()->id);
                $subcontractor->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Supplier deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
