<?php

namespace App\Http\Controllers\Api\Drivers\Jobs;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobAssetsResource;
use App\Http\Resources\JobsResource;
use App\Http\Resources\JobsTimesheetsResource;
use App\Models\Jobs;
use App\Models\JobsAssets;
use App\Models\JobsFieldworkers;
use App\Models\JobsTimesheets;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DriverJobsController extends Controller
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
        $allJobs = [];
        $workers = JobsFieldworkers::where('user_id', Auth::user()->id)->get();
        if (count($workers)>0){
            foreach ($workers as $worker){
                $allJobs[] = Jobs::with('asset')->where('id', $worker->job_id)->first();
            }
        }

        $jobs = JobsResource::collection($allJobs);
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

    public function assignFieldworker(Request $request)
    {
        try {
            $validator_array = [
                'job_id' => 'required',
                'asset_id' => 'required',
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

            if ($jobFieldworker) {
                $error = ['field' => 'job_assign', 'message' => "User already assigned to the job"];
                $errors = [$error];
                return response()->json(['errors' => $errors], 500);
            }
            $jobFieldworker = new JobsFieldworkers();
            $jobFieldworker->job_id = $job->id;
            $jobFieldworker->asset_id = $request->asset_id;
            $jobFieldworker->user_id = $request->user_id;
            $jobFieldworker->save();

            return response()->json([
                'success' => true,
                'message' => 'User successfully assigned to job!',
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

    public function fieldworkers($jobId) {
        $fieldworkers = app(JobsFieldworkers::class)
            ->where('job_id', $jobId)
            ->with('user', 'asset')->get();
        $returnArray = [];
        foreach ($fieldworkers as $fieldworker) {
            $returnArray[] = [
                "name" => $fieldworker->user->name,
                "email" => $fieldworker->user->email
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Users',
            'data' => $returnArray,
        ], 200, [
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        ], JSON_UNESCAPED_UNICODE);
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

    private function assignAssetsToJob(int $jobId, string $assetIdsString)
    {
        $assetIds = explode(',', $assetIdsString);

        foreach ($assetIds as $assetId) {
            $jobAsset = new JobsAssets();
            $jobAsset->job_id = $jobId;
            $jobAsset->asset_id = $assetId;
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
        $job = Jobs::with('client')->where('id', $request->id)->first();
        if ($job) {
            $allocates = JobsFieldworkers::where(['job_id' => $request->id, 'user_id' => Auth::user()->id])->get();
            $assets = [];
            if (count($allocates)>0){
                foreach ($allocates as $allocated){
                    $assets[] = $allocated;
                }
            }
            $job->asset = $assets;
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
                'asset_ids' => 'required',
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
            $job->save();

            JobsAssets::where('job_id', $job->id)->delete();
            $asset_ids = explode(',', $request->asset_ids);
            if (count($asset_ids) > 0) {
                foreach ($asset_ids as $asset_id) {
                    $ja = new JobsAssets();
                    $ja->job_id = $job->id;
                    $ja->asset_id = $asset_id;
                    $ja->save();
                }
            }

            $job = Jobs::with('asset')->where('id', $job->id)->first();
            $job = new JobsResource($job);

            return response()->json([
                'success' => true,
                'message' => 'Job updated successfully!',
                'data' => $job,
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'job_destroy', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    public function timesheets($jobId)
    {
        $timesheets = JobsTimesheets::where(['job_id' => $jobId, 'user_id' => Auth::user()->id])->with('user', 'asset')->get();
        $timesheets = JobsTimesheetsResource::collection($timesheets);

        return response()->json([
            'success' => true,
            'data' => $timesheets,
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

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

    public function deleteTimesheet($id)
    {
        try {
            $timesheetId = $id;
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
}
