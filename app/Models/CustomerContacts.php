<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class CustomerContacts extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'customer_contacts';
    protected bool $revisionCreationsEnabled = true;
}
