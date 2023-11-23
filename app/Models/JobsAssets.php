<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class JobsAssets extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'jobs_assets';
    protected bool $revisionCreationsEnabled = true;

    public function asset()
    {
        return $this->hasOne('App\Models\Assets', 'id', 'asset_id');
    }
}
