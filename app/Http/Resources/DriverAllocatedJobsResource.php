<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverAllocatedJobsResource extends JsonResource
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
                'user_id'=>$this->user_id,
                'asset_name'=>isset($this->asset) ? $this->asset->name: '',
                'job_title'=>isset($this->job) ? $this->job->job_title: '',
                'start_date'=>isset($this->job) ? $this->job->start_date: '',
                'end_date'=>isset($this->job) ? $this->job->end_date: '',
                'job_address'=>isset($this->job) ? $this->job->job_address: '',
                'job_description'=>isset($this->job) ? $this->job->job_description: '',
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
