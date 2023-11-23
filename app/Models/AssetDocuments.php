<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class AssetDocuments extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'asset_documents';
    protected bool $revisionCreationsEnabled = true;

}
