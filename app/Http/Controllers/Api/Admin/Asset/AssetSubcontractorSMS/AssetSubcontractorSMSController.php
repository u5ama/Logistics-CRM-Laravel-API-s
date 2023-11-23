<?php

namespace App\Http\Controllers\Api\Admin\Asset\AssetSubcontractorSMS;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\AssetSubcontractorSMS;
use App\Models\Subcontractor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Aws\Sns\SnsClient;

class AssetSubcontractorSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Subcontractor SMS
     *
     * Check that the Asset Documents is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all sms added for the subcontractor!.
     *
     */

    public function index(Request $request)
    {
        //
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
     * Send Subcontractors SMS
     *
     * Check that the Send Subcontractors SMSt is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Send Subcontractors SMS with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'subcontractors' => 'required',
                'message' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($request->subcontractors) {
                $subcontractors = explode(',', $request->subcontractors);
                $message = $request->message;
                //Send SMS
                $status = $this->sendSMSSub($subcontractors, $message);
                //Send SMS End

                if (count($subcontractors)) {
                    foreach ($subcontractors as $subcontractor) {
                        $sms = new AssetSubcontractorSMS();
                        $sms->subcontractor_id = $subcontractor;
                        $sms->message = $request->message;
                        $sms->status = $status;
                        $sms->save();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'SMS Send successfully!',
                'data' => $sms,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_subcontractor_sms_store','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }


    public function sendSMSSub($subcontractors, $sms)
    {
        //Send SMS
        if (count($subcontractors)>0){
            foreach ($subcontractors as $subcontractor) {
                $subs = Subcontractor::where('id', $subcontractor)->first();
                $sns = new SnsClient([
                    'version' => 'latest',
                    'region' => config('services.sns.region'),
                    'credentials' => [
                        'key' => config('services.sns.key'),
                        'secret' => config('services.sns.secret'),
                    ],
                ]);

                $message = $sms;
                $phoneNumber = $subs->phone;

                $sns->publish([
                    'Message' => $message,
                    'PhoneNumber' => $phoneNumber,
                ]);
            }
            return 'Delivered';
        }
        return 'Not Delivered';
        //Send SMS
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
     *
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     *
     */

    /**
     * Delete SMS
     *
     * Check that the Delete SMS is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $sms = AssetSubcontractorSMS::findorFail($id);
            if ($sms)
            {
                LogActivity::addToLog('SMS Activity Deleted.', Auth::user()->id);
                $sms->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'SMS Activity deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'asset_subcontractor_sms_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
