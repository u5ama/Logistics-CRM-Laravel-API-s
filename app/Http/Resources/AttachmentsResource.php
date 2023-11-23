<?php

namespace App\Http\Resources;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $allTags = [];
        $tags = $this->tags;
        if (count($tags)>0){
            foreach ($tags as $tag){
                $t = Tags::where(['id'=> $tag->tag_id, 'tag_type' => 'attachment'])->first();
                if ($t !== null){
                    $t = new TagsResource($t);
                    $allTags[] = $t;
                }
            }
        }
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'rego_number' => $this->rego_number,
                'make' => $this->make,
                'model' => $this->model,
                'year' => $this->year,
                'serial_number' => $this->serial_number,
                'avg_hourly_rate' => $this->avg_hourly_rate,
                'current_number_reading' => $this->current_number_reading,
                'external_id' => $this->external_id,
                'comments' => $this->comments,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'tags' => $allTags,
            ];
    }
}
