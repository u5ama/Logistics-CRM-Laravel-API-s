<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class QuoteAssets extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'quote_assets';
    protected bool $revisionCreationsEnabled = true;
}
