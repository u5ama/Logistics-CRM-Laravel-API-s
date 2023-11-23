<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class UsersOperatorsRecords extends Model
{
    use HasFactory, RevisionableTrait, SoftDeletes;
    protected $guarded = [];
    protected $table = 'users_operators_records';
    protected bool $revisionCreationsEnabled = true;
}
