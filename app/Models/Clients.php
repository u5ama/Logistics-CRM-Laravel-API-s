<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Clients extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'clients';
    protected bool $revisionCreationsEnabled = true;
}
