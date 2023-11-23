<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Venturecraft\Revisionable\RevisionableTrait;

class DriverDailyChecklist extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'driver_daily_checklist';
    protected bool $revisionCreationsEnabled = true;

    public function job(): HasOne
    {
        return $this->hasOne('App\Models\Jobs', 'id', 'job_id');
    }

    public function driver(): HasOne
    {
        return $this->hasOne('App\Models\User', 'id', 'driver_id');
    }

    public function checklist(): HasOne
    {
        return $this->hasOne('App\Models\JobChecklist', 'id', 'checklist_id');
    }
}
