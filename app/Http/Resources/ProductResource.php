<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->gst_check == 'yes'){
            $gstCheck = true;
        }else{
            $gstCheck = false;
        }
        return
            [
                'id'=>$this->id,
                'name'=>$this->name,
                'description'=>$this->description,
                'docket'=>$this->docket,
                'price'=>$this->price,
                'epa_number'=>$this->epa_number,
                'gst'=>$this->gst,
                'uom'=>$this->uom,
                'gst_check'=> $gstCheck,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
