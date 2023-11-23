<?php

namespace App\Http\Controllers\Api\Admin\Invoicing;

use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Mail\InvoiceMail;
use App\Models\EmailSettings;
use App\Models\InvoiceItems;
use App\Models\InvoiceProducts;
use App\Models\Invoices;
use App\Models\JobsTimesheets;
use App\Models\Products;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Invoices
     *
     * Check that the Invoices is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Invoices added!.
     *
     */

    public function index()
    {
        $invoices = Invoices::with('client','invoiceProducts','invoiceItems')->get();
        $invoices = InvoiceResource::collection($invoices);

        return response()->json([
            'success' => true,
            'data' => $invoices,
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
     * Add Invoice
     *
     * Check that the Add New Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Invoice added with success message!.
     *
     */

    public function store(Request $request)
    {
        try{
            $validator_array = [
                'client_id' => 'required',
                'job_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $invoice = new Invoices();
            $invoice->client_id = $request->client_id;
            $invoice->job_id = $request->job_id;
            $invoice->representative_id = $request->representative_id;
            $invoice->invoice_name = $request->invoice_name;
            $invoice->invoice_status = $request->invoice_status;
            $invoice->invoice_entity = $request->invoice_entity;
            $invoice->save();

            $products = $request->products;
            if (count($products)>0){
                foreach ($products as $product){
                    $invoiceProduct = new InvoiceProducts();
                    $invoiceProduct->invoice_id = $invoice->id;
                    $invoiceProduct->product_id = $product['product_id'];
                    $invoiceProduct->quantity = $product['quantity'];
                    $invoiceProduct->save();

                    $p = Products::where('id', $product['product_id'])->first();
                    $p->price = $product['price'];
                    $p->epa_number = $product['epa_number'];
                    $p->save();
                }
            }

            $inv = Invoices::with('client','invoiceProducts','job')->where('id', $invoice->id)->first();
            $invoice = new InvoiceResource($inv);

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully!',
                'data' => $invoice,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'invoice_store','message'=>$message];
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
     *
     * Show Invoice to create PDF
     *
     * Check that the Show Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Invoice object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $subtotal = [];
        $gst = [];
        $products = [];
        $invoice = Invoices::with('client', 'invoiceProducts','job','invoiceItems')->where('id', $request->id)->first();
        if (count($invoice->invoiceProducts)>0){
            foreach ($invoice->invoiceProducts as $key => $product){
                $pro = Products::where('id', $product->product_id)->first();
                if ($pro){
                    $products[$key] = $pro;
                    $products[$key]['product_id'] = $product->product_id;
                    $products[$key]['quantity'] = $product->quantity;
                    if ($pro){
                        $price = $pro->price * $product->quantity;
                        $subtotal[] = $price;
                        $gst[] = $pro->gst;
                    }else{
                        $price = 0 * $product->quantity;
                        $subtotal[] = $price;
                        $gst[] = 0;
                    }
                }
            }
        }
        $invoice->invoiceProducts = $products;
        $items = [];
        if (count($invoice->invoiceItems)>0){
            foreach ($invoice->invoiceItems as $key => $item){
                $im = JobsTimesheets::with('asset')->where('id', $item->timesheet_id)->first();
                $totalDuration = $item->total_hours;;
                $im->total_time = $item->total_hours;
                $im->invoice_price = $item->invoice_price;
                if ($im->asset){
                    $price = $item->invoice_price * $totalDuration;
                    $subtotal[] = $price;
                    $gst[] = 0;
                }else{
                    $price = 0 * $totalDuration;
                    $subtotal[] = $price;
                    $gst[] = 0;
                }
                $items[] = $im;
            }
            $im = JobsTimesheets::with('asset')->where('id', $invoice->invoiceItems[0]->timesheet_id)->first();
            $invoice->timesheet_id = $im->id;
            $invoice->invoicePrice = $invoice->invoiceItems[0]->invoice_price;
            $invoice->asset_name = $im->asset->name;
        }

        $subtotal = array_sum($subtotal);
        $gst = array_sum($gst);
        $invoice->subTotal = number_format($subtotal,2);
        $invoice->gst = number_format($gst,2);
        $invoice->finalTotal = number_format($subtotal + $gst,2);
        $invoice->invoiceItems = $items;

        if ($invoice)
        {
            $prof = UserProfile::where('user_id', $invoice->client->id)->first();
            $invoice->profile = $prof;

            $invoiceSettings = EmailSettings::where('id',1)->first();
            if ($invoiceSettings){
                $invoice->invoice_settings = $invoiceSettings;
            }
            $invoice = new InvoiceResource($invoice);
            return response()->json([
                'success' => true,
                'data' => $invoice,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'No Invoice found!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     *
     */

    /**
     *
     * Send Email Invoice to Client
     *
     * Check that the Show Send Email Invoice to Client is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be the response that email send successfully!.
     *
     */

    public function sendInvoiceEmail(Request $request)
    {
        try {
            $subtotal = [];
            $gst = [];
            $products = [];
            $invoice = Invoices::with('client', 'invoiceProducts','job')->where('id', $request->id)->first();
            if (count($invoice->invoiceProducts)>0) {
                foreach ($invoice->invoiceProducts as $key => $product) {
                    $pro = Products::where('id', $product->product_id)->first();
                    if ($pro){
                        $products[$key] = $pro;
                        $products[$key]['product_id'] = $product->id;
                        $products[$key]['quantity'] = $product->quantity;
                        $price = $pro->price * $product->quantity;
                        $subtotal[] = $price;
                        $gst[] = $pro->gst;
                    }
                }
            }
            $invoice->invoiceProducts = $products;
            $items = [];
            if (count($invoice->invoiceItems)>0){
                foreach ($invoice->invoiceItems as $key => $item){
                    $im = JobsTimesheets::with('asset')->where('id', $item->timesheet_id)->first();

                    $totalDuration = $item->total_hours;;
                    $im->total_time = $item->total_hours;
                    $im->invoice_price = $item->invoice_price;
                    if ($im->asset){
                        $price = $item->invoice_price * $totalDuration;
                        $subtotal[] = $price;
                        $gst[] = 0;
                    }else{
                        $price = 0 * $totalDuration;
                        $subtotal[] = $price;
                        $gst[] = 0;
                    }
                    $items[] = $im;
                }
            }
            $subtotal = array_sum($subtotal);
            $gst = array_sum($gst);
            $invoice->subTotal = number_format($subtotal,2);
            $invoice->gst = number_format($gst,2);
            $invoice->finalTotal = number_format($subtotal + $gst,2);
            $invoice->invoiceItems = $items;

            $invoiceSettings = EmailSettings::where('id',1)->first();
            if ($invoiceSettings){
                $invoice->invoice_settings = $invoiceSettings;
            }

            $invoice = new InvoiceResource($invoice);
            $mailData = ['invoice' => $invoice];

            Mail::to($invoice->client->email)->send(new InvoiceMail($mailData));

            Invoices::where('id', $request->id)->update([
                'is_sent' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Invoice Email Send successfully!',
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'invoice_email','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */

    /**
     *
     * Update Invoice
     *
     * Check that the Update Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Invoice updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
        try{
            $validator_array = [
                'job_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $validator_array);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 401);
            }

            $invoice = Invoices::where('id', $id)->first();
            $invoice->client_id = $request->client_id;
            $invoice->job_id = $request->job_id;
            $invoice->invoice_name = $request->invoice_name;
            $invoice->invoice_entity = $request->invoice_entity;
            $invoice->invoice_status = $request->invoice_status;
            $invoice->representative_id = $request->representative_id;
            $invoice->save();

            if ($request->timesheet_id)
            {
                $invoiceItem = InvoiceItems::where(['invoice_id' => $invoice->id, 'timesheet_id' => $request->timesheet_id])->first();
                $invoiceItem->invoice_price = $request->invoice_price;
                $invoiceItem->total_hours = $request->total_hours;
                $invoiceItem->save();
            }

            InvoiceProducts::where('invoice_id', $invoice->id)->delete();

            $products = $request->products;
            if (count($products)>0){
                foreach ($products as $product){
                    $invoiceProduct = new InvoiceProducts();
                    $invoiceProduct->invoice_id = $invoice->id;
                    $invoiceProduct->product_id = $product['product_id'];
                    $invoiceProduct->quantity = $product['quantity'];
                    $invoiceProduct->save();

                    $p = Products::where('id', $product['product_id'])->first();
                    $p->price = $product['price'] ?? 0;
                    $p->epa_number = $product['epa_number'];
                    $p->save();
                }
            }
            $inv = Invoices::with('client','invoiceProducts','job')->where('id', $invoice->id)->first();
            $invoice = new InvoiceResource($inv);

            return response()->json([
                'success' => true,
                'message' => 'Invoice updated successfully!',
                'data' => $invoice,
            ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'invoice_update','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|void
     *
     */

    /**
     *
     * Delete Invoice
     *
     * Check that the Delete Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        try {
            $invoice = Invoices::findorFail($id);
            if ($invoice) {

                InvoiceProducts::where('invoice_id', $invoice->id)->delete();
                LogActivity::addToLog('Invoice Deleted.', Auth::user()->id);
                $invoice->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Invoice deleted successfully!',
                ],200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        catch(\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'invoice_destroy','message'=>$message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}
