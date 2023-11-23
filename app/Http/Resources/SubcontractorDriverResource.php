<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubcontractorDriverResource extends JsonResource
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
                'name'=> isset($this->driver) ? $this->driver->name: '',
                'email'=> isset($this->driver) ? $this->driver->email: '',
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
