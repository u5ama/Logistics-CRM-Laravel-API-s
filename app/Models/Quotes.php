<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Quotes extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'quotes';
    protected bool $revisionCreationsEnabled = true;

    public function client()
    {
        return $this->hasOne('App\Models\User', 'id','client_id');
    }

    public function job()
    {
        return $this->hasOne('App\Models\Jobs', 'id','job_id');
    }

    public function quoteItems()
    {
        return $this->hasMany('App\Models\QuoteItems', 'quote_id','id');
    }

    public function sales()
    {
        return $this->hasOne('App\Models\User', 'id','representative_id');
    }

    public function terms()
    {
        return $this->hasOne('App\Models\TermsConditions', 'id','terms_condition_id');
    }
    public function footer()
    {
        return $this->hasOne('App\Models\QuotesFooter', 'id','quote_footer_id');
    }

    public function quoteAssets()
    {
        return $this->hasMany('App\Models\QuoteAssets', 'quote_id','id');
    }
}
