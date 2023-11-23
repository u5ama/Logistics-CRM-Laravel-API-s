<?php

namespace App\Http\Resources;

use App\Models\JobChecklistOptions;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobChecklistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (count($this->items) > 0){
            foreach ($this->items as $item){
                $options = JobChecklistOptions::where('checklist_question_id', $item->id)->get();
                $item['options'] = $options;
            }
        }
        return
            [
                'id'=>$this->id,
                'name'=>$this->checklist_name,
                'checklists'=>$this->items,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at
            ];
    }
}
