<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class JobsFieldworkers extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'jobs_fieldworkers';
    protected bool $revisionCreationsEnabled = true;
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function job()
    {
        return $this->belongsTo('App\Models\Jobs', 'job_id', 'id');
    }
    public function asset()
    {
        return $this->hasOne('App\Models\Assets', 'id', 'asset_id');
    }
}
