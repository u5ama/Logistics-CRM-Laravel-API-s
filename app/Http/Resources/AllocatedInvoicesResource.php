<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AllocatedInvoicesResource extends JsonResource
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
                'subcontractor_id'=>$this->subcontractor_id,
                'subcontractor_name'=>$this->subcontractor->name,
                'amount'=>$this->amount,
                'file'=> Storage::url($this->uploaded_file),
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
