<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class InvoiceProducts extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'invoice_products';
    protected bool $revisionCreationsEnabled = true;
}
