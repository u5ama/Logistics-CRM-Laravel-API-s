<?php

namespace App\Http\Controllers\Api\Admin\EmailSettings;

use App\Http\Controllers\Controller;
use App\Models\EmailSettings;
use App\Models\QuoteSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     */
    /**
     *
     * GET Email Settings for Invoice Template
     *
     * Check that the Email Settings for Invoice Template is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Email Settings for Invoice Template!.
     *
     *
     */
    public function index()
    {
        $invoiceSettings = EmailSettings::where('id',1)->first();
        return response()->json([
            'success' => true,
            'data' => $invoiceSettings,
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
     *
     * Add Email settings for Invoice Template
     *
     * Check that the Add New Email settings for Invoice Template is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be object with email settings added with success message!.
     *
     */
    public function store(Request $request)
    {
        try {
            $validator_array = [
                'account_name' => 'required',
                'account_bsb' => 'required',
                'account_number' => 'required',
                'terms' => 'required',
                'inquiry_email' => 'required',
                'note' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $template = EmailSettings::updateOrCreate([
                'id' => 1
            ],[
                'invoice_template' => $request->invoice_template,
                'quote_template' => $request->quote_template,
                'account_name' => $request->account_name,
                'account_bsb' => $request->account_bsb,
                'account_number' => $request->account_number,
                'terms' => $request->terms,
                'inquiry_email' => $request->inquiry_email,
                'note' => $request->note,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Email Settings Created Successfully!',
                'data' => $template,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'email_settings_store','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     *
     * GET Email Settings for Quote Template
     *
     * Check that the Email Settings for Quote Template is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Email Settings for Quote Template!.
     *
     *
     */

    public function quoteEmailTemplate()
    {
        $quoteSettings = QuoteSettings::where('id',1)->first();
        return response()->json([
            'success' => true,
            'data' => $quoteSettings,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     *
     * Add Email settings for Quote Template
     *
     * Check that the Add New Email settings for Quote Template is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be object with Quote email settings added with success message!.
     *
     */
    public function quoteEmailTemplateSave(Request $request)
    {
        try {
            $validator_array = [
                'terms_conditions' => 'required',
                'op_manager_name' => 'required',
                'op_manager_email' => 'required',
                'op_manager_phone' => 'required',
                'quote_note' => 'required',
                'company_name' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }
            $template = QuoteSettings::updateOrCreate([
                'id' => 1
            ],[
                'terms_conditions' => $request->terms_conditions,
                'op_manager_name' => $request->op_manager_name,
                'op_manager_email' => $request->op_manager_email,
                'op_manager_phone' => $request->op_manager_phone,
                'quote_note' => $request->quote_note,
                'company_name' => $request->company_name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quote Email Settings Created Successfully!',
                'data' => $template,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'quote_email_settings_store','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
