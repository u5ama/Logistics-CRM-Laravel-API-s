<?php

namespace App\Http\Controllers\Api\Admin\Jobs;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AllJobsResource;
use App\Http\Resources\DriverAllocatedJobsResource;
use App\Http\Resources\FieldWorkersResource;
use App\Http\Resources\JobAssetsResource;
use App\Http\Resources\JobsResource;
use App\Http\Resources\JobsTimesheetsResource;
use App\Models\Assets;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\Jobs;
use App\Models\JobsAssets;
use App\Models\JobsFieldworkers;
use App\Models\JobsTimesheets;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Jobs
     *
     * Check that the Jobs is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Jobs added!.
     *
     *
     */

    public function index()
    {
        $jobs = Jobs::with('asset')->get();
        $jobs = JobsResource::collection($jobs);
        return response()->json([
            'success' => true,
            'data' => $jobs,
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getAllJobs()
    {
        $jobs = Jobs::with('asset')->get();
        $jobs = AllJobsResource::collection($jobs);
        return response()->json([
            'success' => true,
            'data' => $jobs,
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
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
     * Add Job
     *
     * Check that the Add New Job is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job added with success message!.
     *
     */

    public function store(Request $request)
    {
        try {
            $validator_array = [
                'asset_ids' => 'required',
                'job_title' => 'required',
                'job_description' => 'required',
                'job_address' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $job = $this->createJob($request);
            $this->assignAssetsToJob($job->id, $request->asset_ids);

            $job = Jobs::with('asset')->where('id', $job->id)->first();
            $jobResource = new JobsResource($job);

            return response()->json([
                'success' => true,
                'message' => 'Job created successfully!',
                'data' => $jobResource,
            ], 200, [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'job_store', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Add Fieldworker to Job
     *
     * Check that the Add New Fieldworker to Job is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Fieldworker to Job added with success message!.
     *
     */

    public function assignFieldworker(Request $request)
    {
        try {
            $validator_array = [
                'job_id' => 'required',
                'user_id' => 'required',
                'asset_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $job = $this->getJob($request->job_id);

            if (!$job)
            {
                $error = ['field' => 'job_assign', 'message' => "Job not found"];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }

            $jobFieldworker = app(JobsFieldworkers::class)
                ->where('asset_id', $request->asset_id)
                ->where('user_id', $request->user_id)
                ->first();

            if ($jobFieldworker) {
                $error = ['field' => 'job_assign', 'message' => "User already assigned to the Asset"];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }

            $jobFieldworker = new JobsFieldworkers();
            $jobFieldworker->job_id = $job->id;
            $jobFieldworker->user_id = $request->user_id;
            $jobFieldworker->asset_id = $request->asset_id;
            $jobFieldworker->save();

            $jobFieldworker = JobsFieldworkers::with('user', 'asset')->where('id', $jobFieldworker->id)->first();
            $jobFieldworker = new FieldWorkersResource($jobFieldworker);

            return response()->json([
                'success' => true,
                'message' => 'User successfully assigned to Asset!',
                'data' => $jobFieldworker,
            ], 200, [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'job_assign', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * All Fieldworkers
     *
     * Check that the Fieldworkers is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Fieldworkers added!.
     *
     */

    public function fieldworkers($jobId)
    {
        $fieldworkers = app(JobsFieldworkers::class)
            ->where('job_id', $jobId)
            ->with('user', 'asset')
            ->get();
        if ($fieldworkers) {
            $fieldworkers = FieldWorkersResource::collection($fieldworkers);
            return response()->json([
                'success' => true,
                'data' => $fieldworkers,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Field Worker found!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function jobAssets($jobId)
    {
        $assets = app(JobsAssets::class)
            ->where('job_id', $jobId)
            ->with('asset')
            ->get();
        if ($assets) {
            $assets = JobAssetsResource::collection($assets);
            return response()->json([
                'success' => true,
                'data' => $assets,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Asset found!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getDriverAllocatedJobs()
    {
        $fieldworkerjobs = app(JobsFieldworkers::class)
            ->where('user_id', Auth::user()->id)
            ->with('job', 'asset')
            ->orderBy('id', 'desc')->take(5)->get();
        if ($fieldworkerjobs) {
            $fieldworkerjobs = DriverAllocatedJobsResource::collection($fieldworkerjobs);
            return response()->json([
                'success' => true,
                'data' => $fieldworkerjobs,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Field Worker found!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getDriverAllocatedJobsForAdmin($driverId)
    {
        $fieldworkerjobs = app(JobsFieldworkers::class)
            ->where('user_id', $driverId)
            ->with('job', 'asset')
            ->get();
        if ($fieldworkerjobs) {
            $fieldworkerjobs = DriverAllocatedJobsResource::collection($fieldworkerjobs);
            return response()->json([
                'success' => true,
                'data' => $fieldworkerjobs,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Field Worker found!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Delete Assigned Fieldworker
     *
     * Check that the Delete Assigned Fieldworker is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */
    public function removeAssignFieldworker(Request $request)
    {
        try {
            $validator_array = [
                'job_id' => 'required',
                'user_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $job = $this->getJob($request->job_id);

            if (!$job) {

                $error = ['field' => 'job_assign', 'message' => "Job not found"];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }

            $jobFieldworker = app(JobsFieldworkers::class)
                ->where('job_id', $job->id)
                ->where('user_id', $request->user_id)
                ->first();

            if (!$jobFieldworker) {
                $error = ['field' => 'job_assign', 'message' => "User is not assigned to this job"];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }
            $jobFieldworker->delete();
            return response()->json([
                'success' => true,
                'message' => 'User successfully removed from the job!',
                'data' => $jobFieldworker,
            ], 200, [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'job_assign', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }


    private function createJob(Request $request): Jobs
    {
        $job = new Jobs();
        $job->job_title = $request->job_title;
        $job->job_description = $request->job_description;
        $job->job_location = $request->job_address;
        $job->client_id = $request->client_id;
        $job->start_date = date('Y-m-d', strtotime($request->start_date));
        $job->end_date = date('Y-m-d', strtotime($request->end_date));
        $job->save();

        return $job;
    }

    private function getJob($job_id)
    {
        return app(Jobs::class)->where('id', $job_id)->first();
    }

    private function assignAssetsToJob(int $jobId, $assetIdsString)
    {
        foreach ($assetIdsString as $asset) {
            $jobAsset = new JobsAssets();
            $jobAsset->job_id = $jobId;
            $jobAsset->asset_id = $asset['asset_id'];
            $jobAsset->start_date = $asset['start_date'];
            $jobAsset->end_date = $asset['end_date'];
            $jobAsset->save();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Show Job
     *
     * Check that the Show Job is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $job = Jobs::with('asset', 'timesheets')->where('id', $request->id)->first();
        if ($job) {
            $job = new JobsResource($job);
            return response()->json([
                'success' => true,
                'data' => $job,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Job found!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
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
     * @param int $id
     * @return JsonResponse
     */

    /**
     * Update Job
     *
     * Check that the Update Job is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'job_title' => 'required',
                'job_description' => 'required',
                'job_address' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $job = Jobs::where('id', $id)->first();
            $job->job_title = $request->job_title;
            $job->job_description = $request->job_description;
            $job->job_location = $request->job_address;
            $job->client_id = $request->client_id;
            $job->start_date = date('Y-m-d', strtotime($request->start_date));
            $job->end_date = date('Y-m-d', strtotime($request->end_date));
            $job->save();

            JobsAssets::where('job_id', $job->id)->delete();
            $this->assignAssetsToJob($job->id, $request->asset_ids);

            $job = Jobs::with('asset')->where('id', $job->id)->first();
            $job = new JobsResource($job);

            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully!',
                'data' => $job,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field' => 'job_update', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */

    /**
     * Delete Job
     *
     * Check that the Delete Job is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $job = Jobs::findorFail($id);
            if ($job) {

                LogActivity::addToLog('Job Deleted.', Auth::user()->id);
                $job->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Job deleted successfully!',
                ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field' => 'job_destroy', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * All Timesheet
     *
     * Check that the Timesheet is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Timesheet added!.
     *
     *
     */
    public function timesheets($jobId)
    {
        $timesheets = $this->getJobTimesheets($jobId);
        $timesheets = JobsTimesheetsResource::collection($timesheets);

        return response()->json([
            'success' => true,
            'data' => $timesheets,
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function allTimesheets()
    {
        $timesheets = JobsTimesheets::with('user')->get();
        $timesheets = JobsTimesheetsResource::collection($timesheets);

        return response()->json([
            'success' => true,
            'data' => $timesheets,
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Add Timesheet
     *
     * Check that the Add New Timesheet is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Timesheet added with success message!.
     *
     */
    public function addTimesheet(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'job_id' => 'required',
                'asset_id' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/jobs/timesheet');
                $name = $file->getClientOriginalName();
            }

            $jobId = $request->job_id;
            $asset_id = $request->asset_id;
            $userId = $request->user_id ?: Auth::user()->id;

            $timesheet = JobsTimesheets::create([
                'job_id' => $jobId,
                'user_id' => $userId,
                'asset_id' => $asset_id,
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'uploaded_file' => $path,
            ]);

            $timesheet = JobsTimesheets::where('id', $timesheet->id)->first();
            $timesheet = new JobsTimesheetsResource($timesheet);

            return response()->json([
                'success' => true,
                'message' => 'Timesheet added successfully!',
                'data' => $timesheet,
            ], 200, [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'job_timesheet_add', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Delete Timesheet
     *
     * Check that the Delete Timesheet is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function deleteTimesheet(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'timesheet_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $timesheetId = $request->timesheet_id;
            $timesheet = app(JobsTimesheets::class)
                ->where('id', $timesheetId)
                ->first();

            if (!$timesheet) {
                $error = ['field' => 'timesheet', 'message' => "Timesheet not found"];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }

            $timesheet->delete();

            return response()->json([
                'success' => true,
                'message' => 'Timesheet deleted successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'timesheet_destroy', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function changeTimeSheetStatus(Request $request, $timesheetId)
    {
        try {
            $timesheet = JobsTimesheets::where('id', $timesheetId)->first();

            $timesheet->invoice_status = $request->status;
            $timesheet->save();

            if ($timesheet->invoice_status = 'Invoiced'){

                $invoice = new Invoices();
                $invoice->client_id = $timesheet->user_id;
                $invoice->job_id = $timesheet->job_id;
                $invoice->save();

                $items = new InvoiceItems();
                $items->invoice_id = $invoice->id;
                $items->timesheet_id = $timesheet->id;
                $items->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Timesheet Invoice Generated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'timesheet_changeStatus','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function createMultiInvoices(Request $request)
    {
        try {
            $timesheets = $request->timesheets;
            if (count($timesheets)>0){
                foreach ($timesheets as $time){
                    if ($time['invoice_status'] != 'Invoiced'){
                        $timesheet = JobsTimesheets::where('id', $time['id'])->first();

                        $timesheet->invoice_status = 'Invoiced';
                        $timesheet->save();

                        $asset = Assets::where('id', $timesheet->asset_id)->first();
                        if ($asset){
                            $avg_hourly_rate = $asset->avg_hourly_rate;
                        }else{
                            $avg_hourly_rate = 0;
                        }

                        if ($timesheet->invoice_status = 'Invoiced'){

                            $job = Jobs::where('id', $timesheet->job_id)->first();
                            $invoice = new Invoices();
                            $invoice->client_id = $job->client_id;
                            $invoice->job_id = $timesheet->job_id;
                            $invoice->save();

                            $startTime = Carbon::parse($timesheet->start_time);
                            $finishTime = Carbon::parse($timesheet->last_time);
                            $totalDuration = $finishTime->diffInHours($startTime);

                            $items = new InvoiceItems();
                            $items->invoice_id = $invoice->id;
                            $items->timesheet_id = $timesheet->id;
                            $items->invoice_price = $avg_hourly_rate;
                            $items->total_hours = $totalDuration;
                            $items->save();
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Timesheet Invoice Generated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'timesheet_invoices','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }


    private function getJobTimesheets($jobId) {
        return JobsTimesheets::where('job_id', $jobId)->with('user')->get();
    }

    private function formatTimesheets($timesheets) {
        return $timesheets->map(function ($timesheet) {
            return [
                "timesheet_id" => $timesheet->id,
                "start_time" => $timesheet->start_time,
                "end_time" => $timesheet->end_time,
                "name" => $timesheet->user->name,
                "is_confirmed" => $timesheet->is_confimed ? 'Y' : 'N',
            ];
        });
    }

    public function getAllDraftInvoices($job_id)
    {
        try {
            $job = Jobs::where('id', $job_id)->first();
            if ($job){
                $invoices = Invoices::where(['job_id'=> $job_id, 'invoice_status' => 'DRAFT', 'client_id' => $job->client_id])->get();
                if (count($invoices)>0){
                    foreach ($invoices as $invoice){
                        $invoice->name = (new \App\Helpers\Utility)->generateFormattedIdForInvoice($invoice->id);
                    }
                }
            }else{
                $invoices = [];
            }

            return response()->json([
                'success' => true,
                'data' => $invoices,
            ], 200, [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'all_draft_invoices','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function addExistingMultiInvoices(Request $request)
    {
        try {
            $timesheets = $request->timesheets;
            if (count($timesheets)>0){
                foreach ($timesheets as $time){
                    if ($time['invoice_status'] != 'Invoiced'){
                        $timesheet = JobsTimesheets::where('id', $time['id'])->first();

                        $timesheet->invoice_status = 'Invoiced';
                        $timesheet->save();

                        $asset = Assets::where('id', $timesheet->asset_id)->first();
                        if ($asset){
                            $avg_hourly_rate = $asset->avg_hourly_rate;
                        }else{
                            $avg_hourly_rate = 0;
                        }

                        if ($timesheet->invoice_status = 'Invoiced'){

                            $job = Jobs::where('id', $timesheet->job_id)->first();
                            $invoice = Invoices::where('id', $request->invoiceId)->first();
                            $invoice->client_id = $job->client_id;
                            $invoice->job_id = $timesheet->job_id;
                            $invoice->save();

                            $startTime = Carbon::parse($timesheet->start_time);
                            $finishTime = Carbon::parse($timesheet->last_time);
                            $totalDuration = $finishTime->diffInHours($startTime);

                            $items = new InvoiceItems();
                            $items->invoice_id = $invoice->id;
                            $items->timesheet_id = $timesheet->id;
                            $items->invoice_price = $avg_hourly_rate;
                            $items->total_hours = $totalDuration;
                            $items->save();
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Timesheet Invoice Generated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'timesheet_invoices','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    private function dateFormat($date){

        // Parse the ISO 8601 date into a Carbon instance
        $carbonDate = Carbon::parse($date);

        // Format the Carbon instance as a simple date (YYYY-MM-DD)
         return $carbonDate->format('Y-m-d');
    }
    public function updateJobDate(Request $request)
    {
        try {
            $job_id = $request->jobId;

            $job = Jobs::with('asset')->where('id', $job_id)->first();
            if ($job)
            {
                $job->start_date = $this->dateFormat($request->start);
                $job->end_date  = $this->dateFormat($request->end);
;
                $job->save();
            }

            $job = new AllJobsResource($job);

            return response()->json([
                'success' => true,
                'data' => $job,
                'message' => 'Job Updated successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'job_date_update','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
