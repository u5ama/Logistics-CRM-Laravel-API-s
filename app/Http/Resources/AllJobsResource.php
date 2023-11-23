<?php

namespace App\Http\Resources;

use App\Models\Assets;
use App\Models\JobsTimesheets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AllJobsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $allAssets = [];
        $assets = $this->asset;

        if (count($assets)>0){
            foreach ($assets as $asset){
                $a = Assets::where(['id'=> $asset->asset_id])->first();
                if ($a !== null) {
                    $a->asset_id = $asset->asset_id;
                    $a->start_date = $asset->start_date;
                    $a->end_date = $asset->end_date;
                    $allAssets[] = $a;
                }
            }
        }
        return
            [
                'id' => $this->id,
                'title' => $this->job_title,
                'start' => Carbon::parse($this->start_date)->format('Y-m-d'),
                'end' => Carbon::parse($this->end_date)->format('Y-m-d'),
                'content' => $this->job_description,
                'job_address' => $this->job_location,
                'client_name' => isset($this->client) ? $this->client->name : '',
                'assets' => $allAssets,
                'allDay' => true,
            ];
    }
}
