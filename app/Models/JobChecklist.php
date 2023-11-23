<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Venturecraft\Revisionable\RevisionableTrait;

class JobChecklist extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'job_checklist';
    protected bool $revisionCreationsEnabled = true;

    public function items(): HasMany
    {
        return $this->hasMany('App\Models\JobChecklistItems', 'checklist_id', 'id');
    }
}
