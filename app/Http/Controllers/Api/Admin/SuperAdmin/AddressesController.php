<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\UserAddresses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All User Addresses
     *
     * Check that the User Addresses is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all addresses added by a user!.
     *
     */

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $address = UserAddresses::where('user_id', $user_id)->get();

        return response()->json([
            'success' => true,
            'data' => $address,
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
     * Add User Address
     *
     * Check that the Add User Address is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all addresses added by a user with success message!.
     */

    public function store(Request $request)
    {
        try{
            $address = UserAddresses::create([
                'user_id' => $request->user_id,
                'address' => $request->address,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Address created successfully!',
                'data' => $address,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'address_create','message'=>$message];
            $errors =[$error];
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
     * Show Address
     *
     * Check that the Show Address is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be address object for a specific id sent by User!.
     *
     */

    public function show(Request $request)
    {
        $address = UserAddresses::where('id', $request->id)->first();
        if ($address)
        {
            return response()->json([
                'success' => true,
                'data' => $address,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No address found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id)
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
     * Update User Address
     *
     * Check that the Update User Address is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be address updated by a user with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try {
            $address = UserAddresses::where(['user_id' => $request->user_id, 'id' => $id])->first();
            $address->user_id = $request->user_id;
            $address->address = $request->address;
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!',
                'data' => $address,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'address_update','message'=>$message];
            $errors =[$error];
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
     * Delete Address
     *
     * Check that the Delete User Address is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $address = UserAddresses::findorFail($id);
            if ($address) {

                LogActivity::addToLog('User address Deleted.', Auth::user()->id);
                $address->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Address deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'address_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
