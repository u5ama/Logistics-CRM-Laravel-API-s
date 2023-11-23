<?php

namespace App\Http\Controllers\Api\Admin\Subcontractor;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\Subcontractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubcontractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Subcontractors
     *
     * Check that the Subcontractors is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Subcontractors added!.
     *
     *
     */

    public function index()
    {
        $subcontractor = Subcontractor::all();
        if (count($subcontractor) > 0){
            foreach ($subcontractor as $subcontract){
                $tags = json_decode($subcontract->tags, true);
                $subcontract->tags = $tags;
            }
        }
        return response()->json([
            'success' => true,
            'data' => $subcontractor,
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
     * Add Subcontractor
     *
     * Check that the Add New Subcontractor is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractor added with success message!.
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

            $subcontractor = new Subcontractor();
            $subcontractor->name = $request->name;
            $subcontractor->email = $request->email;
            $subcontractor->phone = $request->phone;
            $subcontractor->abn = $request->abn;
            if ($request->tags){
                $tags = json_encode($request->tags);
                $subcontractor->tags = $tags;
            }
            $subcontractor->save();

            return response()->json([
                'success' => true,
                'message' => 'Subcontractor created successfully!',
                'data' => $subcontractor,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_store','message'=>$message];
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
     * Show Subcontractor
     *
     * Check that the Show Subcontractor is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractor object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $subcontractor = Subcontractor::where('id', $request->id)->first();
        if ($subcontractor)
        {
            $subcontractor->tags = json_decode($subcontractor->tags, true);
            return response()->json([
                'success' => true,
                'data' => $subcontractor,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Subcontractor found!',
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
     * Update Subcontractor
     *
     * Check that the Update Subcontractor is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractor updated with success message!.
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
            $subcontractor = Subcontractor::where('id', $id)->first();
            $subcontractor->name = $request->name;
            $subcontractor->email = $request->email;
            $subcontractor->phone = $request->phone;
            $subcontractor->abn = $request->abn;
            if ($request->tags){
                $tags = json_encode($request->tags);
                $subcontractor->tags = $tags;
            }
            $subcontractor->save();

            return response()->json([
                'success' => true,
                'data' => $subcontractor,
                'message' => 'Subcontractor updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_update','message'=>$message];
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
     * Delete Subcontractor
     *
     * Check that the Delete Subcontractor is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $subcontractor = Subcontractor::findorFail($id);
            if ($subcontractor) {

                LogActivity::addToLog('Subcontractor Deleted.', Auth::user()->id);
                $subcontractor->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Subcontractor deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
