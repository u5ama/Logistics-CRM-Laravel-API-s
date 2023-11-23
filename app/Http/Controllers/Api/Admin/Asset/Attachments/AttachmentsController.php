<?php

namespace App\Http\Controllers\Api\Admin\Asset\Attachments;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttachmentsResource;
use App\Models\AssetAttachments;
use App\Models\AttachmentTagRelation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Asset Attachments
     *
     * Check that All Asset Attachments is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of Attachments with tags!.
     *
     */

    public function index()
    {
        $attachments = AssetAttachments::with('tags')->get();
        $attachments = AttachmentsResource::collection($attachments);

        return response()->json([
            'success' => true,
            'data' => $attachments,
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
     * Add Attachment
     *
     * Check that the Add Attachment is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Attachment added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $attachment = new AssetAttachments();
            $attachment->name = $request->name;
            $attachment->description = $request->description;
            $attachment->rego_number = $request->rego_number;
            $attachment->year = $request->year;
            $attachment->model = $request->model;
            $attachment->make = $request->make;
            $attachment->serial_number = $request->serial_number;
            $attachment->avg_hourly_rate = $request->avg_hourly_rate;
            $attachment->current_number_reading = $request->current_number_reading;
            $attachment->external_id = $request->external_id;
            $attachment->comments = $request->comments;
            $attachment->save();

            if ($request->tags){
                $tags = explode(',',$request->tags);
                if(count($tags)>0){
                    foreach ($tags as $t){
                        $tag = new AttachmentTagRelation();
                        $tag->attachment_id  = $attachment->id ;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }

            $attachment = AssetAttachments::with('tags')->where('id', $attachment->id)->first();
            $attachment = new AttachmentsResource($attachment);

            return response()->json([
                'success' => true,
                'message' => 'Attachment created successfully!',
                'data' => $attachment,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'attachment_store','message'=>$message];
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
     * Show Attachment
     *
     * Check that the Get/Show Attachment is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Attachment object with tags linked for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $attachment = AssetAttachments::with('tags')->where('id', $request->id)->first();
        if ($attachment)
        {
            $attachment = new AttachmentsResource($attachment);
            return response()->json([
                'success' => true,
                'data' => $attachment,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Attachment found!',
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
     * Update Attachment
     *
     * Check that the Update Attachment is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Attachment updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try{
            $validator_array = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $attachment = AssetAttachments::where('id', $id)->first();
            $attachment->name = $request->name;
            $attachment->description = $request->description;
            $attachment->rego_number = $request->rego_number;
            $attachment->year = $request->year;
            $attachment->model = $request->model;
            $attachment->make = $request->make;
            $attachment->serial_number = $request->serial_number;
            $attachment->avg_hourly_rate = $request->avg_hourly_rate;
            $attachment->current_number_reading = $request->current_number_reading;
            $attachment->external_id = $request->external_id;
            $attachment->comments = $request->comments;
            $attachment->save();

            if ($request->tags){
                $tags = explode(',',$request->tags);
                if(count($tags)>0){
                    AttachmentTagRelation::where('attachment_id', $id)->delete();
                    foreach ($tags as $t){
                        $tag = new AttachmentTagRelation();
                        $tag->attachment_id  = $id ;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }

            $attachment = AssetAttachments::with('tags')->where('id', $id)->first();
            $attachment = new AttachmentsResource($attachment);

            return response()->json([
                'success' => true,
                'message' => 'Attachment updated successfully!',
                'data' => $attachment,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'attachment_update','message'=>$message];
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
     * Delete Attachment
     *
     * Check that the Delete Attachment is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message if the attachment removed!.
     */

    public function destroy($id)
    {
        try {
            $attachment = AssetAttachments::findorFail($id);
            if ($attachment) {

                LogActivity::addToLog('Attachment Deleted.', Auth::user()->id);
                $attachment->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Attachment deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'attachment_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
