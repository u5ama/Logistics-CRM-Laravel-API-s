<?php

namespace App\Http\Controllers\Api\Admin\Asset\Skills;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillsResource;
use App\Models\Skills;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All Skills
     *
     * Check that All Skills is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Skills!.
     *
     */

    public function index()
    {
        $skills = Skills::all();
        $skills = SkillsResource::collection($skills);

        return response()->json([
            'success' => true,
            'data' => $skills,
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
     * Add Skill
     *
     * Check that the Add Skill is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Skill added with success message!.
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

            $skill = new Skills();
            $skill->name = $request->name;
            $skill->save();

            $skill = new SkillsResource($skill);

            return response()->json([
                'success' => true,
                'message' => 'Skill created successfully!',
                'data' => $skill,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'skill_store','message'=>$message];
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
     * Show Skill
     *
     * Check that the Show Skill is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Skill object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $skill = Skills::where('id', $request->id)->first();
        if ($skill)
        {
            return response()->json([
                'success' => true,
                'data' => $skill,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Skill found!',
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
     * Update Skill
     *
     * Check that the Update Skill is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Skill updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $tag = Skills::where('id', $id)->first();
            $tag->name = $request->name;
            $tag->save();

            return response()->json([
                'success' => true,
                'data' => $tag,
                'message' => 'Skill updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'skills_update','message'=>$message];
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
     * Delete Skill
     *
     * Check that the Delete Skill is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a deleted success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $skill = Skills::findorFail($id);
            if ($skill) {

                LogActivity::addToLog('Skill Deleted.', Auth::user()->id);
                $skill->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Skill deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'skills_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
