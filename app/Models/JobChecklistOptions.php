<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class JobChecklistOptions extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'job_checklist_options';
    protected bool $revisionCreationsEnabled = true;
}
