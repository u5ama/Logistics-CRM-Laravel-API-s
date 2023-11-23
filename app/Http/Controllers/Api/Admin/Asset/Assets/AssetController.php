<?php

namespace App\Http\Controllers\Api\Admin\Asset\Assets;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetsResource;
use App\Models\Assets;
use App\Models\AssetsAttachments;
use App\Models\AssetsChecklist;
use App\Models\AssetsCompetencyTags;
use App\Models\AssetsResourceTags;
use App\Models\AssetsSkills;
use App\Models\AssetsTags;
use App\Models\AssetSubcontractor;
use App\Models\AssetsWorkers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Assets
     *
     * Check that All Assets is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of Assets with tags, skills, workers, attachments and subcontractors!.
     *
     */

    public function index()
    {
        $assets = Assets::with('tag', 'competency_tags', 'resource_tags', 'skills', 'workers', 'subcontractor', 'checklist')->get();

        $assets = AssetsResource::collection($assets);

        return response()->json([
            'success' => true,
            'data' => $assets,
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
     * Add Asset
     *
     * Check that the Add Asset is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Asset added with success message and all the details!.
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

            $path = '';
            if ($file = $request->file('photo')) {
                $path = $file->store('public/assets/files');
                $name = $file->getClientOriginalName();
            }

            $asset = new Assets();
            $asset->name = $request->name;
            $asset->description = $request->description;
            $asset->rego_number = $request->rego_number;
            $asset->year = $request->year;
            $asset->model = $request->model;
            $asset->make = $request->make;
            $asset->serial_number = $request->serial_number;
            $asset->avg_hourly_rate = $request->avg_hourly_rate;
            $asset->current_number_reading = $request->current_number_reading;
            $asset->external_id = $request->external_id;
            $asset->comments = $request->comments;
            $asset->photo = $path;
            $asset->save();

            if ($request->checklists){
                $checklist = explode(',',$request->checklists);
                if(count($checklist)>0){
                    foreach ($checklist as $c){
                        $check = new AssetsChecklist();
                        $check->asset_id  = $asset->id ;
                        $check->checklist_id = $c;
                        $check->save();
                    }
                }
            }

            if ($request->asset_attachments){
                $attachments = explode(',',$request->asset_attachments);
                if(count($attachments)>0){
                    foreach ($attachments as $t){
                        $attach = new AssetsAttachments();
                        $attach->asset_id  = $asset->id ;
                        $attach->attachment_id = $t;
                        $attach->save();
                    }
                }
            }
            //Asset tags
            if ($request->tags) {
                $tags = explode(',', $request->tags);
                if (count($tags) > 0) {
                    foreach ($tags as $t) {
                        $tag = new AssetsTags();
                        $tag->asset_id = $asset->id;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }
            //Competency Tags
            if ($request->competencyTags) {
                $tags = explode(',', $request->competencyTags);
                if (count($tags) > 0) {
                    foreach ($tags as $t) {
                        $tag = new AssetsCompetencyTags();
                        $tag->asset_id = $asset->id;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }
            //resource Tags
            if ($request->resourceTags) {
                $tags = explode(',', $request->resourceTags);
                if (count($tags) > 0) {
                    foreach ($tags as $t) {
                        $tag = new AssetsResourceTags();
                        $tag->asset_id = $asset->id;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }

            if ($request->skills) {
                $skills = explode(',', $request->skills);
                if (count($skills) > 0) {
                    foreach ($skills as $t) {
                        $skill = new AssetsSkills();
                        $skill->asset_id = $asset->id;
                        $skill->skill_id = $t;
                        $skill->save();
                    }
                }
            }

            if ($request->workers) {
                $workers = explode(',', $request->workers);
                if (count($workers) > 0) {
                    foreach ($workers as $t) {
                        $worker = new AssetsWorkers();
                        $worker->asset_id = $asset->id;
                        $worker->worker_id = $t;
                        $worker->save();
                    }
                }
            }

            /*if ($request->subcontractors) {
                $subcontractors = explode(',', $request->subcontractors);
                if (count($subcontractors) > 0) {
                    foreach ($subcontractors as $t) {
                        $sub = new AssetSubcontractor();
                        $sub->asset_id = $asset->id;
                        $sub->subcontractor_id = $t;
                        $sub->save();
                    }
                }
            }*/

            $asset = Assets::with('tag', 'competency_tags', 'resource_tags', 'skills', 'workers', 'subcontractor', 'checklist')->where('id', $asset->id)->first();
            $asset = new AssetsResource($asset);

            return response()->json([
                'success' => true,
                'message' => 'Asset created successfully!',
                'data' => $asset,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'asset_store','message'=>$message];
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
     * Show Asset
     *
     * Check that the Get/Show Asset is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Asset object with tags, skills, workers, attachments and subcontractors linked for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $asset = Assets::with('tag', 'competency_tags', 'resource_tags', 'skills', 'workers', 'subcontractor', 'checklist')->where('id', $request->id)->first();
        if ($asset)
        {
            $asset = new AssetsResource($asset);
            return response()->json([
                'success' => true,
                'data' => $asset,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Asset found!',
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
     *
     */

    /**
     * Update Asset
     *
     * Check that the Update Asset is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Asset added with success message!.
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

            if ($file = $request->file('photo')) {
                $path = $file->store('public/assets/files');
                $name = $file->getClientOriginalName();
            }

            $asset = Assets::where('id', $id)->first();
            if (empty($path)){
                $path = $asset->photo;
            }
            $asset->name = $request->name;
            $asset->description = $request->description;
            $asset->rego_number = $request->rego_number;
            $asset->year = $request->year;
            $asset->model = $request->model;
            $asset->make = $request->make;
            $asset->serial_number = $request->serial_number;
            $asset->avg_hourly_rate = $request->avg_hourly_rate;
            $asset->current_number_reading = $request->current_number_reading;
            $asset->external_id = $request->external_id;
            $asset->comments = $request->comments;
            $asset->photo = $path;
            $asset->save();

            if ($request->checklists){
                $checklist = explode(',',$request->checklists);
                if(count($checklist)>0){
                    AssetsChecklist::where('asset_id', $id)->delete();
                    foreach ($checklist as $c){
                        $check = new AssetsChecklist();
                        $check->asset_id  = $asset->id ;
                        $check->checklist_id = $c;
                        $check->save();
                    }
                }
            }

            if ($request->asset_attachments) {
                $attachments = explode(',', $request->asset_attachments);
                if (count($attachments) > 0) {
                    AssetsAttachments::where('asset_id', $id)->delete();
                    foreach ($attachments as $t) {
                        $attach = new AssetsAttachments();
                        $attach->asset_id = $asset->id;
                        $attach->attachment_id = $t;
                        $attach->save();
                    }
                }
            }

            //Tags
            if ($request->tags) {
                $tags = explode(',', $request->tags);
                if (count($tags) > 0) {
                    AssetsTags::where('asset_id', $id)->delete();
                    foreach ($tags as $t) {
                        $tag = new AssetsTags();
                        $tag->asset_id = $asset->id;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }

            //Competency Tags
            if ($request->competencyTags) {
                $tags = explode(',', $request->competencyTags);
                if (count($tags) > 0) {
                    AssetsCompetencyTags::where('asset_id', $id)->delete();
                    foreach ($tags as $t) {
                        $tag = new AssetsCompetencyTags();
                        $tag->asset_id = $asset->id;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }
            //resource Tags
            if ($request->resourceTags) {
                $tags = explode(',', $request->resourceTags);
                if (count($tags) > 0) {
                    AssetsResourceTags::where('asset_id', $id)->delete();
                    foreach ($tags as $t) {
                        $tag = new AssetsResourceTags();
                        $tag->asset_id = $asset->id;
                        $tag->tag_id = $t;
                        $tag->save();
                    }
                }
            }

            if ($request->skills) {
                $skills = explode(',', $request->skills);
                if (count($skills) > 0) {
                    AssetsSkills::where('asset_id', $id)->delete();
                    foreach ($skills as $t) {
                        $skill = new AssetsSkills();
                        $skill->asset_id = $asset->id;
                        $skill->skill_id = $t;
                        $skill->save();
                    }
                }
            }

            if ($request->workers) {
                $workers = explode(',', $request->workers);
                if (count($workers) > 0) {
                    AssetsWorkers::where('asset_id', $id)->delete();
                    foreach ($workers as $t) {
                        $worker = new AssetsWorkers();
                        $worker->asset_id = $asset->id;
                        $worker->worker_id = $t;
                        $worker->save();
                    }
                }
            }

            if ($request->subcontractors) {
                $subcontractors = explode(',', $request->subcontractors);
                if (count($subcontractors) > 0) {
                    AssetSubcontractor::where('asset_id', $id)->delete();
                    foreach ($subcontractors as $t) {
                        $sub = new AssetSubcontractor();
                        $sub->asset_id = $asset->id;
                        $sub->subcontractor_id = $t;
                        $sub->save();
                    }
                }
            }

            $asset = Assets::with('tag', 'competency_tags', 'resource_tags', 'skills', 'workers', 'subcontractor', 'checklist')->where('id', $id)->first();
            $asset = new AssetsResource($asset);

            return response()->json([
                'success' => true,
                'message' => 'Asset updated successfully!',
                'data' => $asset,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'asset_update','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     *
     */

    /**
     * Delete Asset
     *
     * Check that the Delete Asset is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message if the asset is removed!.
     */

    public function destroy($id)
    {
        try {
            $asset = Assets::findorFail($id);
            if ($asset) {

                LogActivity::addToLog('Asset Deleted.', Auth::user()->id);
                $asset->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Asset deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e){
            $message = $e->getMessage();
            $error = ['field'=>'asset_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
