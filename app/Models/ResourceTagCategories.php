<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class ResourceTagCategories extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'resource_tag_categories';
    protected bool $revisionCreationsEnabled = true;
}
