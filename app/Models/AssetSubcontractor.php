<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class AssetSubcontractor extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'assets_subcontractor';
    protected bool $revisionCreationsEnabled = true;

    public function subcontractor()
    {
        return $this->hasOne('App\Models\Subcontractor', 'id', 'subcontractor_id');
    }
}
