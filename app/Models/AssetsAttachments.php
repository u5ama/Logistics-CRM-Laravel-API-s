<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class AssetsAttachments extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'assets_attachments';
    protected bool $revisionCreationsEnabled = true;
}
