<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Documents extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'users_documents';
    protected bool $revisionCreationsEnabled = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
