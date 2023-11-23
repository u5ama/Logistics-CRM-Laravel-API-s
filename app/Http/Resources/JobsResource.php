<?php

namespace App\Http\Resources;

use App\Models\Assets;
use App\Models\JobsTimesheets;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class JobsResource extends JsonResource
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
        $allTimesheets = [];
        $assets = $this->asset;
        $timesheets = $this->timesheets;

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
        if (count($timesheets)>0){
            foreach ($timesheets as $timesheet){
                $t = JobsTimesheets::with('asset')->where(['id'=> $timesheet->id])->first();
                if ($t !== null) {
                    $t->asset_id = $timesheet->asset_id;
                    $t->start_time = $timesheet->start_time;
                    $t->end_time = $timesheet->end_time;
                    $t->is_confirmed = $timesheet->is_confimed ? 'Y' : 'N';
                    $t->file= Storage::url($timesheet->uploaded_file);
                    $t->asset_name = isset($timesheet->asset) ? $timesheet->asset->name: '';
                    $allTimesheets[] = $t;
                }
            }
        }
        return
            [
                'id'=>$this->id,
                'assets'=> $allAssets,
                'timesheets'=> $allTimesheets,
                'job_title'=>$this->job_title,
                'job_description'=>$this->job_description,
                'job_address'=>$this->job_location,
                'client_id'=>$this->client_id,
                'client_name'=> isset($this->client) ? $this->client->name : '',
                'checklist_id'=>$this->checklist_id,
                'start_date'=>$this->start_date,
                'end_date'=>$this->end_date,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ];
    }
}
