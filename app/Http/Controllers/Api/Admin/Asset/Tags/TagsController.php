<?php

namespace App\Http\Controllers\Api\Admin\Asset\Tags;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Models\Tags;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Tags
     *
     * Check that the Tags is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of Tags for given tag type!.
     *
     */

    public function index(Request $request)
    {
        $tags = Tags::where('tag_type', $request->tag_type)->get();
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
     */

    /**
     * Add Tag
     *
     * Check that the Add Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Tag added with tag type and success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'name' => 'required',
                'tag_type' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $tag = new Tags();
            $tag->name = $request->name;
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
            $error = ['field'=>'tags_store','message'=>$message];
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
     * Show Tag
     *
     * Check that the Get/Show Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Tag object for a specific id!.
     */

    public function show(Request $request)
    {
        $tag = Tags::where('id', $request->id)->first();
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
                'message' => 'No Tag found!',
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
     * @param  int  $id
     * @return JsonResponse
     */

    /**
     * Update Tag
     *
     * Check that the Update Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Tag added with tag type and success message!.
     *
     */
    public function update(Request $request, $id)
    {
        try {
            $validator_array = [
                'name' => 'required',
                'tag_type' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $tag = Tags::where('id', $id)->first();
            $tag->name = $request->name;
            $tag->tag_type = $request->tag_type;
            $tag->save();

            return response()->json([
                'success' => true,
                'data' => $tag,
                'message' => 'Tag updated successfully!',
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'tags_update','message'=>$message];
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
     * Delete Tag
     *
     * Check that the Delete Tag is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message if the tag removed!.
     */

    public function destroy($id)
    {
        try {
            $tag = Tags::findorFail($id);
            if ($tag) {

                LogActivity::addToLog('Tag Deleted.', Auth::user()->id);
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
            $error = ['field'=>'tags_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
