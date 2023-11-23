<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class QuoteSettings extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'quotes_settings';
    protected bool $revisionCreationsEnabled = true;
}
