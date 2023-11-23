<?php

namespace App\Http\Controllers\Api\Admin\Jobs;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\DriverDailyChecklistResource;
use App\Http\Resources\JobChecklistResource;
use App\Models\DriverDailyChecklist;
use App\Models\JobChecklist;
use App\Models\JobChecklistItems;
use App\Models\JobChecklistOptions;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */
    /**
     * All Job Checklists
     *
     * Check that the Job Checklists is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Job Checklists added!.
     *
     *
     */
    public function index()
    {
        $checklists = JobChecklist::with('items')->get();
        $checklists = JobChecklistResource::collection($checklists);
        return response()->json([
            'success' => true,
            'data' => $checklists,
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
     *
     * Add Job Checklist
     *
     * Check that the Add New Job Checklist is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job Checklist added with success message!.
     *
     */
    public function store(Request $request)
    {
        try {
            $validator_array = [
                'name' => 'required',
                'checklists' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $checklist = new JobChecklist();
            $checklist->checklist_name = $request->name;
            $checklist->save();
            if (count($request->checklists)>0){
                foreach ($request->checklists as $check)
                {
                    $item = new JobChecklistItems();
                    $item->checklist_id = $checklist->id;
                    $item->checklist_question = $check['checkbox_question'];
                    $item->select_type = $check['selectedOption']['value'];
                    $item->save();

                    if ($check['selectedOption']['value'] != "text"){
                        if (count($check['checkListOptions'])>0){
                            foreach ($check['checkListOptions'] as $option){
                                JobChecklistOptions::create([
                                    'checklist_question_id' => $item->id,
                                    'option_name' => $option['name'],
                                ]);
                            }
                        }
                    }
                }
            }
            $checklist = JobChecklist::with('items')->first();
            $checklist = new JobChecklistResource($checklist);

            return response()->json([
                'success' => true,
                'message' => 'Checklist created successfully!',
                'data' => $checklist,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'checklist_store','message'=>$message];
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
     * Show Job Checklist
     *
     * Check that the Show Job Checklist is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job Checklist object for a specific id!.
     *
     */
    public function show(Request $request)
    {
        $checklist = JobChecklist::with('items')->where('id', $request->id)->first();
        if ($checklist)
        {
            $checklist = new JobChecklistResource($checklist);
            return response()->json([
                'success' => true,
                'data' => $checklist,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Checklist found!',
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
     */
    /**
     * Delete Job Checklist
     *
     * Check that the Delete Job Checklist is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $checklist = JobChecklist::findorFail($id);
            if ($checklist)
            {
                JobChecklistItems::where('checklist_id', $checklist->id)->delete();
                LogActivity::addToLog('Checklist Deleted.', Auth::user()->id);
                $checklist->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Checklist deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'checklist_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Show Driver Checklist to submit
     *
     * Check that the Show Driver Checklist is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver Checklist object for a specific id!.
     *
     */

    public function driverChecklist(Request $request)
    {
        $checklist = JobChecklist::with('items')->where('id', $request->id)->first();
        if ($checklist)
        {
            $checklist = new JobChecklistResource($checklist);
            return response()->json([
                'success' => true,
                'data' => $checklist,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Checklist found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     *
     * Add Driver Checklist
     *
     * Check that the Add New Driver Checklist is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver Checklist added with success message!.
     *
     */

    public function saveDriverChecklist(Request $request)
    {
        try {
            $dt = Carbon::now();
            $today = $dt->toDateString();

            $checks = DriverDailyChecklist::where('checklist_id',$request->checklistId)->get();
            if (count($checks)>0){
                foreach ($checks as $check){
                    $created = $check->created_at->toDateString();
                    if ($created == $today){
                        return response()->json([
                            'success' => false,
                            'message' => 'Checklist already added for today!',
                        ],401, ['Content-Type' => 'application/json; charset=UTF-8',
                            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
                    }
                }
            }

            $selectedChecklist = json_encode($request->selectedChecklist);
            $checklist = new DriverDailyChecklist();
            $checklist->checklist_id = $request->checklistId;
            $checklist->driver_id = Auth::user()->id;

            //** Here assetId is being used as JobId */
            $checklist->job_id = $request->jobId;

            $checklist->selected_checklist = $selectedChecklist;
            $checklist->save();

            return response()->json([
                'success' => true,
                'message' => 'Checklist created successfully!',
                'data' => $checklist,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'driver_checklist_save','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Show Driver all Checklists
     *
     * Check that the Show Driver all Checklists is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver all Checklists array for a specific id!.
     *
     */

    public function driverChecklists(Request $request)
    {
        $checklists = DriverDailyChecklist::with('checklist','driver')->where(['driver_id'=> $request->driverId, 'job_id' => $request->id])->get();
        $checklists = DriverDailyChecklistResource::collection($checklists);
        return response()->json([
            'success' => true,
            'data' => $checklists,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show Driver single Checklist Details
     *
     * Check that the Show Driver single Checklist Details is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver single Checklist Details object for a specific id!.
     *
     */
    public function driverSingleChecklist(Request $request)
    {
        $checklist = DriverDailyChecklist::with('checklist','driver')
            ->where(['checklist_id'=> $request->id])
            ->first();
        if ($checklist){
            $checklist = new DriverDailyChecklistResource($checklist);
            return response()->json([
                'success' => true,
                'data' => $checklist,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else{
            return response()->json([
                'success' => false,
                'message' => 'No Checklist found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function driverChecklistDetail(Request $request)
    {
        $checklist = JobChecklist::with('items')->where('id', $request->id)->first();
        if ($checklist)
        {
            $checklist = new JobChecklistResource($checklist);
            return response()->json([
                'success' => true,
                'data' => $checklist,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Checklist found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }
}
