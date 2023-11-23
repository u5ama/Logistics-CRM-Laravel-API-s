<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserActivitiesResource extends JsonResource
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
                'name'=>$this->userResponsible()->name,
                'field'=>$this->fieldName(),
                'oldValue'=>$this->oldValue(),
                'newValue'=>$this->newValue(),
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at
            ];
    }
}
