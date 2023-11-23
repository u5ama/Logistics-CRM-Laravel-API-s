<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class InvoiceItems extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'invoice_items';
    protected bool $revisionCreationsEnabled = true;
}
