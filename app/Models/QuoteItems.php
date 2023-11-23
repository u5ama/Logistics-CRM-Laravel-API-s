<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class QuoteItems extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'quote_items';
    protected bool $revisionCreationsEnabled = true;
}
