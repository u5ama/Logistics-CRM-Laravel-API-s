<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class AttachmentTagRelation extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'attachment_tags';
    protected bool $revisionCreationsEnabled = true;
}
