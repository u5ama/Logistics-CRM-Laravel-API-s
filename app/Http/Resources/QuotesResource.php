<?php

namespace App\Http\Resources;

use App\Helpers\Utility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotesResource extends JsonResource
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
                'id'=> $this->id,
                'quote_id'=> (new \App\Helpers\Utility)->generateFormattedId($this->id),
                'quote_name'=>$this->quote_name,
                'job_id'=>$this->job_id,
                'representative_id'=>$this->representative_id,
                'terms_condition_id'=>$this->terms_condition_id,
                'terms_condition_text'=>$this->terms_condition_text,
                'quote_footer_text'=>$this->quote_footer_text,
                'quote_footer_id'=>$this->quote_footer_id,
                'job_title'=>isset($this->job) ? $this->job->job_title : null,
                'client_id'=>isset($this->client) ? $this->client->id : null,
                'client_name'=>isset($this->client) ? $this->client->name : null,
                'client_address'=>isset($this->profile) ? $this->profile->address : $this->profile,
                'client_email'=>isset($this->client) ? $this->client->email : null,
                'location'=> $this->location,
                'total_price'=> $this->total_price,
                'quote_status'=> ($this->quote_status == 'NotApproved')? 'Not Accepted' : 'Accepted',
                'items'=> $this->quoteItems,
                'quote_entity'=> $this->quote_entity,
                'settings'=> isset($this->setting) ? $this->setting : null,
                'terms_conditions'=> $this->terms_condition_text,
                'over_rate'=> $this->quote_footer_text,
                'material_type'=> $this->material_type,
                'assets'=> isset($this->quoteAssets) ? $this->quoteAssets : null,
                'created_at'=> $this->created_at,
                'updated_at'=> $this->updated_at,
            ];
    }
}
