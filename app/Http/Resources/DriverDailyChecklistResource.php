<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverDailyChecklistResource extends JsonResource
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
                'id' => $this->id,
                'driver_name' => $this->driver->name,
                'checklist_id' => $this->checklist->id,
                'checklist_name' => $this->checklist->checklist_name,
                'selected_checklist' => json_decode($this->selected_checklist, true),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
    }
}
