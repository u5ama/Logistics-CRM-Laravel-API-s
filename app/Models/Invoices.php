<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Invoices extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'invoicing';
    protected bool $revisionCreationsEnabled = true;

    public function client()
    {
        return $this->hasOne('App\Models\User', 'id','client_id');
    }

    public function job()
    {
        return $this->hasOne('App\Models\Jobs', 'id','job_id');
    }

    public function invoiceProducts()
    {
        return $this->hasMany('App\Models\InvoiceProducts', 'invoice_id','id');
    }
    public function invoiceItems()
    {
        return $this->hasMany('App\Models\InvoiceItems', 'invoice_id','id');
    }
}
