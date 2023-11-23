<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetSubcontractorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'subcontractor_id' => $this->subcontractor->id,
                'name' => $this->subcontractor->name,
                'phone' => $this->subcontractor->phone,
                'charge_type' => $this->charge_type,
                'charge_unit' => $this->charge_unit,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
