<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ClientDocumentsResource extends JsonResource
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
                'title'=>$this->title,
                'file'=> Storage::url($this->uploaded_file),
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
