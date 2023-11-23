<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Models\UserTags;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */

    /**
     * All User Tags
     *
     * Check that the User Tags is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Tags added for the User!.
     *
     */

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $tags = UserTags::where(['user_id'=> $user_id, 'tag_type'=> $request->tag_type])->get();
        $tags = TagsResource::collection($tags);

        return response()->json([
            'success' => true,
            'data' => $tags,
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
     * Add User Tag
     *
     * Check that the Add New User Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be User Tag added with success message!.
     *
     */
    public function store(Request $request)
    {
        try{
            $tag = new UserTags();
            $tag->name = $request->name;
            $tag->user_id = $request->user_id;
            $tag->tag_type = $request->tag_type;
            $tag->save();

            $tag = new TagsResource($tag);

            return response()->json([
                'success' => true,
                'message' => 'Tag created successfully!',
                'data' => $tag,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'user_tags_create','message'=>$message];
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
     * Show User Tag
     *
     * Check that the Show User Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be User Tag object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $tag = UserTags::where('id', $request->id)->first();
        if ($tag)
        {
            return response()->json([
                'success' => true,
                'data' => $tag,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No tag found!',
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
     * Delete User Tag
     *
     * Check that the Delete User Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */
    public function destroy($id)
    {
        try {
            $tag = UserTags::findorFail($id);
            if ($tag) {

                LogActivity::addToLog('User tag Deleted.', Auth::user()->id);
                $tag->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Tag deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'user_tag_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
