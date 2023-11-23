<?php

namespace App\Http\Controllers\Api\Admin\Subcontractor;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubcontractorDocumentsResource;
use App\Mail\ReminderMail;
use App\Models\Subcontractor;
use App\Models\SubcontractorDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class SubcontractorDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Subcontractor Documents
     *
     * Check that the Subcontractor Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all documents added for the Subcontractor!.
     *
     */
    public function index(Request $request)
    {
        $subcontractor_id = $request->subcontractor_id;
        $documents = SubcontractorDocuments::where('subcontractor_id', $subcontractor_id)->get();
        $documents = SubcontractorDocumentsResource::collection($documents);

        $this->checkReminder($documents);

        return response()->json([
            'success' => true,
            'data' => $documents,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function checkReminder($documents)
    {
        try {
            if (count($documents) > 0) {
                foreach ($documents as $document) {
                    $now = Carbon::now()->format('Y-m-d');
                    if ($document->reminder == $now) {
                        $user = Subcontractor::where('id', $document->subcontractor_id)->first();
                        if ($user) {
                            $user->document = $document;
                            Mail::to($user->email)->send(new ReminderMail($user));
                        }
                    }
                }
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_documents_email','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
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
     * Add Subcontractor Document
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
                'title' => 'required',
                'reminder' => 'required',
                'upload_file' => 'required|mimes:doc,docx,pdf,txt,csv,png,jpg,jpeg|max:5000',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($file = $request->file('upload_file')) {
                $path = $file->store('public/subcontractor/Documents');
                $name = $file->getClientOriginalName();
            }

            $document = SubcontractorDocuments::create([
                'subcontractor_id' => $request->subcontractor_id,
                'title' => $request->title,
                'reminder' => $request->reminder,
                'uploaded_file' => $path,
            ]);

            $document = new SubcontractorDocumentsResource($document);

            return response()->json([
                'success' => true,
                'message' => 'Subcontractor Document created successfully!',
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'subcontractor_documents_store','message'=>$message];
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
     * Show Subcontractor Document
     *
     * Check that the Show Subcontractor Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractor Document object for a specific id!.
     *
     */
    public function show(Request $request)
    {
        $document = SubcontractorDocuments::where('id', $request->id)->first();
        if ($document)
        {
            $document = new SubcontractorDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Subcontractor Document found!',
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
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }

    public function changeDocumentStatus($id)
    {
        $document = SubcontractorDocuments::where('id', $id)->first();
        if ($document)
        {
            if ($document->status == 'NotApproved'){
                $document->status = 'Approved';
            }else{
                $document->status = 'NotApproved';
            }
            $document->save();

            $document = new SubcontractorDocumentsResource($document);
            return response()->json([
                'success' => true,
                'data' => $document,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Subcontractor Document found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }
}
