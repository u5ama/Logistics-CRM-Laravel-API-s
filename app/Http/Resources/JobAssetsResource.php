<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobAssetsResource extends JsonResource
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
                'id' => isset($this->asset) ? $this->asset->id: '',
                'name' => isset($this->asset) ? $this->asset->name: '',
                'description' => isset($this->asset) ? $this->asset->description: '',
                'created_at'=> $this->created_at,
                'updated_at'=> $this->updated_at,
            ];
    }
}
