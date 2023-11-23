<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class JobsTimesheetsResource extends JsonResource
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
                'asset_id'=>$this->asset_id,
                'start_time'=>$this->start_time,
                'end_time'=>$this->end_time,
                'name'=>$this->user->name,
                'asset_name'=>isset($this->asset) ? $this->asset->name: '',
                "is_confirmed" => $this->is_confimed ? 'Y' : 'N',
                'file'=> Storage::url($this->uploaded_file),
                'invoice_status'=>$this->invoice_status,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
