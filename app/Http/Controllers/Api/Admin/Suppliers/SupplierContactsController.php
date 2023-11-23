<?php

namespace App\Http\Controllers\Api\Admin\Suppliers;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierContactsResource;
use App\Models\SupplierContacts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Suppliers Contact
     *
     * Check that the Suppliers Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Suppliers Contact added based on specific supplier ID!.
     *
     */

    public function index(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $contacts = SupplierContacts::where('supplier_id', $supplier_id)->get();
        $contacts = SupplierContactsResource::collection($contacts);
        return response()->json([
            'success' => true,
            'data' => $contacts,
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
     * Add Supplier Contact
     *
     * Check that the Add New Supplier Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Contact added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'supplierId' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $supplier = new SupplierContacts();
            $supplier->supplier_id = $request->supplierId;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->save();

            $supplier = new SupplierContactsResource($supplier);

            return response()->json([
                'success' => true,
                'message' => 'Supplier Contact created successfully!',
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_contact_store','message'=>$message];
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
     * Show Supplier Contact
     *
     * Check that the Show Supplier Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Contact object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $supplier = SupplierContacts::where('id', $request->id)->first();
        if ($supplier)
        {
            $supplier = new SupplierContactsResource($supplier);

            return response()->json([
                'success' => true,
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Contact found!',
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
     * Update Supplier Contact
     *
     * Check that the Update Supplier Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Supplier Contact updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try{
            $validator_array = [
                'supplierId' => 'required',
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $supplier = SupplierContacts::where(['supplier_id'=>$request->supplierId, 'id' => $id])->first();
            $supplier->supplier_id = $request->supplierId;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->save();

            $supplier = new SupplierContactsResource($supplier);

            return response()->json([
                'success' => true,
                'message' => 'Supplier Contact updated successfully!',
                'data' => $supplier,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_contact_update','message'=>$message];
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
     * Delete Supplier Contact
     *
     * Check that the Delete Supplier Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $supplier = SupplierContacts::findorFail($id);
            if ($supplier) {

                LogActivity::addToLog('Supplier Contact Deleted.', Auth::user()->id);
                $supplier->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Supplier Contact deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'supplier_contact_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
