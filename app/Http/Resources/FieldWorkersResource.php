<?php

namespace App\Http\Resources;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldWorkersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $profile = UserProfile::where('user_id', $this->user->id)->first();
        return
            [
                'id'=> $this->id,
                'user_id'=> isset($this->user) ? $this->user->id: '',
                'name'=> isset($this->user) ? $this->user->name: '',
                'phone'=> isset($profile) ? $profile->phone: '',
                'asset_name'=> isset($this->asset) ? $this->asset->name: '',
                'email'=> isset($this->user) ? $this->user->email: '',
                'created_at'=> $this->created_at,
                'updated_at'=> $this->updated_at,
            ];
    }
}
