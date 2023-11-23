<?php

namespace App\Http\Controllers\Api\Admin\Subcontractor;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubcontractorDriverResource;
use App\Models\SubcontractorDrivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SubcontractorDriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Subcontractor Drivers
     *
     * Check that the Subcontractor Drivers is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Drivers added for the Subcontractor!.
     *
     */
    public function index(Request $request)
    {
        $subcontractor_id = $request->subcontractor_id;
        $drivers = SubcontractorDrivers::with('driver')->where('subcontractor_id', $subcontractor_id)->get();
        $drivers = SubcontractorDriverResource::collection($drivers);

        return response()->json([
            'success' => true,
            'data' => $drivers,
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
     * Add Subcontractor Driver
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
                'subcontractor_id' => 'required',
                'user_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $driver = new SubcontractorDrivers();
            $driver->subcontractor_id = $request->subcontractor_id;
            $driver->user_id = $request->user_id;
            $driver->save();

            $driver = SubcontractorDrivers::with('driver')->where('id', $driver->id)->first();
            $driver = new SubcontractorDriverResource($driver);

            return response()->json([
                'success' => true,
                'message' => 'Subcontractor Driver created successfully!',
                'data' => $driver,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_driver_store','message'=>$message];
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
     * Show Subcontractor Driver
     *
     * Check that the Show Subcontractor Driver is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractor Driver object for a specific id!.
     *
     */
    public function show(Request $request)
    {
        $driver = SubcontractorDrivers::with('driver')->where('id', $request->id)->first();
        if ($driver)
        {
            $driver = new SubcontractorDriverResource($driver);
            return response()->json([
                'success' => true,
                'data' => $driver,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Subcontractor driver found!',
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
     */
    public function destroy($id)
    {
        try {
            $driver = SubcontractorDrivers::findorFail($id);
            if ($driver) {

                LogActivity::addToLog('Subcontractor Driver Deleted.', Auth::user()->id);
                $driver->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Subcontractor driver deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_driver_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
