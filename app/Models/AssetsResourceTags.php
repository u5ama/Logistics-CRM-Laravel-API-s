<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class AssetsResourceTags extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'assets_resource_tags';
    protected bool $revisionCreationsEnabled = true;


    public function resource_tags()
    {
        return $this->belongsTo('App\Models\Tags','tag_id');
    }
}
