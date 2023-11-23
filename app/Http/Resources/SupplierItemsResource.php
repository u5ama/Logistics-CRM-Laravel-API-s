<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierItemsResource extends JsonResource
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
                'supplierId'=>$this->supplier_id,
                'item_code'=>$this->item_code,
                'item_description'=>$this->item_description,
                'site'=>$this->site,
                'unit_price'=>$this->unit_price,
                'gst_incl'=>$this->gst_incl,
                'UOM'=>$this->UOM,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
