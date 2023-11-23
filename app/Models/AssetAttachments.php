<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class AssetAttachments extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'asset_attachments';
    protected bool $revisionCreationsEnabled = true;

    public function tags()
    {
        return $this->hasMany('App\Models\AttachmentTagRelation', 'attachment_id', 'id');
    }
}


