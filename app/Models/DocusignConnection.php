<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class DocusignConnection extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'docusign_connection';
    protected bool $revisionCreationsEnabled = true;
}
