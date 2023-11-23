<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Products extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'products';
    protected bool $revisionCreationsEnabled = true;
}
