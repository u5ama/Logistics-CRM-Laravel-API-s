<?php

namespace App\Http\Resources;

use App\Models\AssetAttachments;
use App\Models\JobChecklist;
use App\Models\Skills;
use App\Models\Subcontractor;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AssetsResource extends JsonResource
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
        $tags = $this->tag;
        if (count($tags)>0){
            foreach ($tags as $tag){
                $t = Tags::where(['id'=> $tag->tag_id, 'tag_type' => 'asset'])->first();
                if ($t !== null) {
                    $t = new TagsResource($t);
                    $allTags[] = $t;
                }
            }
        }

        $allCompetencyTags = [];
        $tags = $this->competency_tags;
        if (count($tags)>0){
            foreach ($tags as $tag){
                $t = Tags::where(['id'=> $tag->tag_id, 'tag_type' => 'competency'])->first();
                if ($t !== null) {
                    $t = new TagsResource($t);
                    $allCompetencyTags[] = $t;
                }
            }
        }

        $allResourceTags = [];
        $tags = $this->resource_tags;
        if (count($tags)>0){
            foreach ($tags as $tag){
                $t = Tags::where(['id'=> $tag->tag_id, 'tag_type' => 'resource'])->first();
                if ($t !== null) {
                    $t = new TagsResource($t);
                    $allResourceTags[] = $t;
                }
            }
        }

        $allSkills = [];
        $skills = $this->skills;
        if (count($skills)>0){
            foreach ($skills as $skill){
                $s = Skills::where(['id'=> $skill->skill_id])->first();
                if ($s !== null) {
                    $s = new SkillsResource($s);
                    $allSkills[] = $s;
                }
            }
        }

        $allWorkers = [];
        $workers = $this->workers;
        if (count($workers)>0){
            foreach ($workers as $worker){
                $w = User::where(['id'=> $worker->worker_id])->first();
                if ($w !== null) {
                    $w = new UserResource($w);
                    $allWorkers[] = $w;
                }
            }
        }

        $allSubcontractors = [];
        $subcontractors = $this->subcontractor;
        if (count($subcontractors)>0){
            foreach ($subcontractors as $subcontractor){
                $s = Subcontractor::where(['id'=> $subcontractor->subcontractor_id])->first();
                if ($s !== null) {
                    $s = new SubcontractorResource($s);
                    $allSubcontractors[] = $s;
                }
            }
        }

        $allAttachments = [];
        $attachments = $this->attachments;
        if (count($attachments)>0){
            foreach ($attachments as $attachment){
                $a = AssetAttachments::where('id', $attachment->attachment_id)->first();
                if ($a !== null) {
                    $a = new AttachmentsResource($a);
                    $allAttachments[] = $a;
                }
            }
        }

        $allChecklists = [];
        $checklists = $this->checklist;
        if (count($checklists)>0){
            foreach ($checklists as $checklist){
                $a = JobChecklist::with('items')->where('id', $checklist->checklist_id)->first();
                if ($a !== null) {
                    $a = new JobChecklistResource($a);
                    $allChecklists[] = $a;
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
                'photo' => Storage::url($this->photo),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'tags' => $allTags,
                'competencyTags' => $allCompetencyTags,
                'resourceTags' => $allResourceTags,
                'skills' => $allSkills,
                'workers' => $allWorkers,
                'subcontractors' => $allSubcontractors,
                'checklists' => $allChecklists,
                'attachments' => $allAttachments,
            ];
    }
}
