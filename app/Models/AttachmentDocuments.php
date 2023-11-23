<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class AttachmentDocuments extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'attachment_documents';
    protected bool $revisionCreationsEnabled = true;
}
