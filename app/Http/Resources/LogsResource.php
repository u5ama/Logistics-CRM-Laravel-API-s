<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogsResource extends JsonResource
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
                'subject'=>$this->subject,
                'url'=>$this->url,
                'method'=>$this->method,
                'ip'=>$this->ip,
                'agent'=>$this->agent,
                'username'=>isset($this->user) ? $this->user->name: '',
                'user_type'=>isset($this->user) ? $this->user->user_type: '',
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at
            ];
    }
}
