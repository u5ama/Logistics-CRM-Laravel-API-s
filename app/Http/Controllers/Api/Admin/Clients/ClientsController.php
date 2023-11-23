<?php

namespace App\Http\Controllers\Api\Admin\Clients;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientsResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoices;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All clients / customers
     *
     * Check that the clients / customers is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all clients / customers added!.
     *
     *
     */

    public function index()
    {
        $clients = User::with('userProfile')->where('user_type', 2)->get();
        $clients = ClientsResource::collection($clients);

        return response()->json([
            'success' => true,
            'data' => $clients,
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
     * Add client / customer
     *
     * Check that the Add New client / customer is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be client / customer added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'name' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required',
                'address' => 'required',
                'password' => 'required',
                'abn' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $client = new User();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->password = Hash::make($request->password);
            $client->user_status = 'active';
            $client->user_type = 2;
            $client->save();

            $userProf = new UserProfile();
            $userProf->user_id = $client->id;
            $userProf->address = $request->address;
            $userProf->phone = $request->phone;
            $userProf->abn = $request->abn;

            $userProf->account_terms = $request->account_terms;

            if ($request->account_terms == 'Credit'){
                $userProf->credit_limit = $request->credit_limit;
                if ($request->credit_activity == true){
                    $userProf->credit_activity = 'yes';
                }else{
                    $userProf->credit_activity = 'no';
                }
            }
            $userProf->save();

            $client = User::with('userProfile')->where('id', $client->id)->first();
            $client = new ClientsResource($client);

            return response()->json([
                'success' => true,
                'message' => 'Client created successfully!',
                'data' => $client,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_store','message'=>$message];
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
     * Show client / customer
     *
     * Check that the Show client / customer is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be client / customer object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $client = User::with('userProfile')->where('id', $request->id)->first();
        if ($client)
        {
            $client = new ClientsResource($client);
            return response()->json([
                'success' => true,
                'data' => $client,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Client found!',
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
     * Update client / customer
     *
     * Check that the Update clients / customers is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be client / customer updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|string|email|max:255',
                'address' => 'required',
                'abn' => 'required'
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $client = User::where('id', $id)->first();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->user_status = 'active';
            $client->user_type = 2;
            $client->save();

            $userProf = UserProfile::where('user_id', $client->id)->first();
            $userProf->user_id = $client->id;
            $userProf->address = $request->address;
            $userProf->phone = $request->phone;
            $userProf->abn = $request->abn;

            $userProf->account_terms = $request->account_terms;
            if ($request->account_terms == 'Credit'){
                $userProf->credit_limit = $request->credit_limit;
                if ($request->credit_activity == true){
                    $userProf->credit_activity = 'yes';
                }else{
                    $userProf->credit_activity = 'no';
                }
            }

            $userProf->save();

            $client = User::with('userProfile')->where('id', $client->id)->first();
            $client = new ClientsResource($client);

            return response()->json([
                'success' => true,
                'data' => $client,
                'message' => 'Client updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_update','message'=>$message];
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
     * Delete client / customer
     *
     * Check that the Delete client / customer is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $client = User::findorFail($id);
            if ($client) {
                UserProfile::where('id', $id)->delete();
                LogActivity::addToLog('Client Deleted.', Auth::user()->id);
                $client->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Client deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Show client / customer Invoices
     *
     * Check that the Show client / customer Invoices is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be client / customer Invoice array for a specific id!.
     *
     */
    public function getClientInvoices(Request $request)
    {
        try {
            $invoices = Invoices::with('client','invoiceProducts')->where('client_id', $request->client_id)->get();
            $invoices = InvoiceResource::collection($invoices);

            return response()->json([
                'success' => true,
                'data' => $invoices,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_invoices','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
