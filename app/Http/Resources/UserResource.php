<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'name'=>$this->name,
                'email'=>$this->email,
                'user_type'=>$this->user_type,
                'user_status'=>$this->user_status,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
                'userRole'=>$this->userRole,
                'user_profile'=>$this->userProfile,
                'total_notes'=>$this->notes,
            ];
    }
}
