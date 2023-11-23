<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class DriverJobDocument extends Model
{
    use HasFactory, RevisionableTrait;
    protected $guarded = [];
    protected $table = 'driver_job_documents';
    protected bool $revisionCreationsEnabled = true;
}
