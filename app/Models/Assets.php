<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class Assets extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'assets';
    protected bool $revisionCreationsEnabled = true;

    public function tag()
    {
        return $this->hasMany('App\Models\AssetsTags', 'asset_id', 'id');
    }
    public function competency_tags()
    {
        return $this->hasMany('App\Models\AssetsCompetencyTags', 'asset_id', 'id');
    }
    public function resource_tags()
    {
        return $this->hasMany('App\Models\AssetsResourceTags', 'asset_id', 'id');
    }

    public function skills()
    {
        return $this->hasMany('App\Models\AssetsSkills', 'asset_id', 'id');
    }

    public function workers()
    {
        return $this->hasMany('App\Models\AssetsWorkers', 'asset_id', 'id');
    }

    public function subcontractor()
    {
        return $this->hasMany('App\Models\AssetSubcontractor', 'asset_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\AssetsAttachments', 'asset_id', 'id');
    }

    public function checklist()
    {
        return $this->hasMany('App\Models\AssetsChecklist', 'asset_id', 'id');
    }
}
