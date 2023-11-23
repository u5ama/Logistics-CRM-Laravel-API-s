<?php

namespace App\Http\Controllers\Api\Admin\Asset\AssetSubcontractor;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetSubcontractorResource;
use App\Models\AssetSubcontractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssetSubcontractorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Asset Subcontractors
     *
     * Check that the Asset Subcontractors is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Subcontractors added for the asset!.
     *
     */

    public function index(Request $request)
    {
        $asset_id = $request->asset_id;
        $subcontractors = AssetSubcontractor::with('subcontractor')->where('asset_id', $asset_id)->get();
        $subcontractors = AssetSubcontractorResource::collection($subcontractors);
        return response()->json([
            'success' => true,
            'data' => $subcontractors,
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
     * Add Asset Subcontractor
     *
     * Check that the Add Asset Subcontractor is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractors added for the asset with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'asset_id' => 'required',
                'subcontractor_id' => 'required',
                'charge_type' => 'required',
                'charge_unit' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $subcontractor = new AssetSubcontractor();
            $subcontractor->asset_id = $request->asset_id;
            $subcontractor->subcontractor_id = $request->subcontractor_id;
            $subcontractor->charge_type = $request->charge_type;
            $subcontractor->charge_unit = $request->charge_unit;
            $subcontractor->save();

            $subcontractor = AssetSubcontractor::with('subcontractor')->where('id', $subcontractor->id)->first();
            $subcontractor = new AssetSubcontractorResource($subcontractor);

            return response()->json([
                'success' => true,
                'message' => 'Asset Subcontractor created successfully!',
                'data' => $subcontractor,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_subcontractor_store','message'=>$message];
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
     * Show Subcontractor
     *
     * Check that the Show Subcontractor is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Subcontractor object for a specific id for the asset!.
     *
     */

    public function show(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        try{
            $validator_array = [
                'subcontractor_id' => 'required',
                'charge_type' => 'required',
                'charge_unit' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $subcontractor = AssetSubcontractor::where('id', $id)->first();
            $subcontractor->subcontractor_id = $request->subcontractor_id;
            $subcontractor->charge_type = $request->charge_type;
            $subcontractor->charge_unit = $request->charge_unit;
            $subcontractor->save();

            $subcontractor = AssetSubcontractor::with('subcontractor')->where('id', $subcontractor->id)->first();
            $subcontractor = new AssetSubcontractorResource($subcontractor);

            return response()->json([
                'success' => true,
                'message' => 'Asset Subcontractor updated successfully!',
                'data' => $subcontractor,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_subcontractor_update','message'=>$message];
            $errors = [$error];
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
     * Delete Document
     *
     * Check that the Delete Asset Document is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $subcontractor = AssetSubcontractor::findorFail($id);
            if ($subcontractor)
            {
                LogActivity::addToLog('Asset Subcontractor Deleted.', Auth::user()->id);
                $subcontractor->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Asset Subcontractor deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_subcontractor_destroy','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
