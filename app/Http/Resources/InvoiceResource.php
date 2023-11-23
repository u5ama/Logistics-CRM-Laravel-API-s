<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                'id'=>$this->id,
                'invoice_id'=> (new \App\Helpers\Utility)->generateFormattedIdForInvoice($this->id),
                'invoice_name'=>$this->invoice_name,
                'client_id'=>$this->client->id,
                'representative_id'=>$this->representative_id,
                'client_name'=>isset($this->client) ? $this->client->name : null,
                'client_phone'=>isset($this->profile) ? $this->profile->phone : null,
                'client_email'=>isset($this->client) ? $this->client->email : null,
                'client_address'=>isset($this->profile) ? $this->profile->address : null,
                'job_id'=>$this->job_id,
                'job_title'=>isset($this->job) ? $this->job->job_title : null,
                'job_address'=>isset($this->job) ? $this->job->job_location : null,
                'job_description'=>isset($this->job) ? $this->job->job_description : null,
                'products'=> $this->invoiceProducts,
                'items'=> $this->invoiceItems ?? null,
                'subTotal' => $this->subTotal,
                'finalTotal' => $this->finalTotal,
                'invoice_entity' => $this->invoice_entity,
                'gst' => $this->gst,
                'invoice_settings' => $this->invoice_settings ?? null,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
                'invoice_status'=>$this->invoice_status,
                'timesheet_id'=>$this->timesheet_id,
                'asset_name'=>$this->asset_name,
                'invoice_price'=>$this->invoicePrice,
                'is_paid'=>$this->is_paid ? 'Yes' : 'No',
                'is_sent'=>$this->is_sent ? 'Yes' : 'No',
            ];
    }
}
