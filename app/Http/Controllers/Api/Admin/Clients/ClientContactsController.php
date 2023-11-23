<?php

namespace App\Http\Controllers\Api\Admin\Clients;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerContactsResource;
use App\Models\CustomerContacts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    /**
     * All Client Contacts
     *
     * Check that the Client Contacts is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Contacts added for the Client!.
     *
     */
    public function index(Request $request)
    {
        $client_id = $request->client_id;
        $contacts = CustomerContacts::where('user_id', $client_id)->get();
        $contacts = CustomerContactsResource::collection($contacts);

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
     */
    /**
     * Add Client Contact
     *
     * Check that the Add Client Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be contact added for the Client with success message!.
     *
     */
    public function store(Request $request)
    {
        try{
            $validator_array = [
                'user_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'title' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $contact = new CustomerContacts();
            $contact->user_id = $request->user_id;
            $contact->first_name = $request->first_name;
            $contact->last_name = $request->last_name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->address = $request->address;
            $contact->title = $request->title;
            $contact->save();

            $contact = new CustomerContactsResource($contact);

            return response()->json([
                'success' => true,
                'message' => 'Customer Contact created successfully!',
                'data' => $contact,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_contact_store','message'=>$message];
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
     * Show Contact
     *
     * Check that the Show Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Contact object for a specific id for the Client!.
     *
     */
    public function show(Request $request)
    {
        $contact = CustomerContacts::where('id', $request->id)->first();
        if ($contact)
        {
            $contact = new CustomerContactsResource($contact);
            return response()->json([
                'success' => true,
                'data' => $contact,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Customer Contact found!',
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
     * Delete Contact
     *
     * Check that the Delete Client Contact is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */
    public function destroy($id)
    {
        try {
            $contact = CustomerContacts::findorFail($id);
            if ($contact)
            {
                LogActivity::addToLog('Customer Contact Deleted.', Auth::user()->id);
                $contact->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Customer Contact deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'client_contacts_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
