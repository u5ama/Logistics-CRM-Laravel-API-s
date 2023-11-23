<?php

namespace App\Http\Controllers\Api\Drivers\Jobs;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobDocumentsResource;
use App\Models\DriverJobDocument;
use App\Models\JobDocuments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverJobsDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Job Documents
     *
     * Check that the Job Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Job Documents added!.
     *
     *
     */

    public function index(Request $request)
    {
        $job_id = $request->job_id;
        $documents = DriverJobDocument::where(['job_id'=> $job_id, 'driver_id' => Auth::user()->id])->get();
        $documents = JobDocumentsResource::collection($documents);

        return response()->json([
            'success' => true,
            'data' => $documents,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function AllJobDocument(Request $request)
    {
        $driver_id = $request->driver_id;
        $documents = DriverJobDocument::where(['driver_id' => $driver_id])->get();
        $documents = JobDocumentsResource::collection($documents);

        return response()->json([
            'success' => true,
            'data' => $documents,
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
     * Add Job Document
     *
     * Check that the Add Job Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job Document added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'job_id' => 'required',
                'title' => 'required',
                'hire_docket' => 'required',
//                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/jobs/Documents');
                $name = $file->getClientOriginalName();
            }
            if ($request->manual_image) {
                $folderPath = "public/jobs/Documents/";
                $base64Image = explode(";base64,", $request->manual_image);
                $explodeImage = explode("image/", $base64Image[0]);
                $imageType = $explodeImage[1];
                $image_base64 = base64_decode($base64Image[1]);
                $path = $folderPath . uniqid() . '. '.$imageType;
                Storage::put($path, $image_base64);
            }

            $document = DriverJobDocument::create([
                'driver_id' => Auth::user()->id,
                'job_id' => $request->job_id,
                'title' => $request->title,
                'hire_docket' => $request->hire_docket,
                'uploaded_file' => $path,
            ]);

            $document = new JobDocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Job Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'job_documents_store','message'=>$message];
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
     * Show Job Document
     *
     * Check that the Show Job Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Job Document object for a specific id sent by User!.
     */

    public function show(Request $request)
    {
        $document = JobDocuments::where('id', $request->id)->first();
        if ($document)
        {
            $document = new JobDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Job Document found!',
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
     *
     */

    /**
     * Delete Job Document
     *
     * Check that the Delete Job Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     */

    public function destroy($id)
    {
        try {
            $document = DriverJobDocument::findorFail($id);
            if ($document)
            {
                LogActivity::addToLog('Job Document Deleted.', Auth::user()->id);
                $document->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Job Document deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'job_documents_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
