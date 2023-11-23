<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Venturecraft\Revisionable\RevisionableTrait;

class Jobs extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'jobs';
    protected bool $revisionCreationsEnabled = true;

    public function asset(): HasMany
    {
        return $this->hasMany('App\Models\JobsAssets', 'job_id', 'id');
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany('App\Models\JobsTimesheets', 'job_id', 'id');
    }

    public function checklist(): HasOne
    {
        return $this->hasOne('App\Models\JobChecklist', 'checklist_id', 'id');
    }

    public function client(): HasOne
    {
        return $this->hasOne('App\Models\User', 'id', 'client_id');
    }
}
