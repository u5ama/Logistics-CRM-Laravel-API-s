<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class SubcontractorDocuments extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'subcontractor_documents';
    protected bool $revisionCreationsEnabled = true;

    public function subcontractor()
    {
        return $this->hasOne('App\Models\Subcontractor', 'id','subcontractor_id');
    }
}
