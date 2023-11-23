<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->userProfile){
            if ($this->userProfile->credit_activity == 'yes'){
                $activity = true;
            }else{
                $activity = false;
            }
        }
        return
            [
                'id'=>$this->id,
                'name'=>$this->name,
                'email'=>$this->email,
                'user_type'=>$this->user_type,
                'user_status'=>$this->user_status,
                'phone'=>isset($this->userProfile) ? $this->userProfile->phone : null,
                'address'=>isset($this->userProfile) ? $this->userProfile->address: null,
                'abn'=> isset($this->userProfile) ? $this->userProfile->abn : null,
                'account_terms'=> isset($this->userProfile) ? $this->userProfile->account_terms : null,
                'credit_limit'=> isset($this->userProfile) ? $this->userProfile->credit_limit : null,
                'credit_activity'=> $activity ?? false,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
