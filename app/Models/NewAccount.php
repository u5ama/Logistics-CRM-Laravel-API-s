<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class NewAccount extends Model
{
    use HasFactory, SoftDeletes, HasRoles, RevisionableTrait;

    protected bool $revisionCreationsEnabled = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function companyInformation()
    {
        return $this->hasOne('App\Models\UsersCompanyInformation', 'user_id','id');
    }
    public function companyAddress()
    {
        return $this->hasOne('App\Models\UsersCompanyAddress', 'user_id','id');
    }
    public function bankDetails()
    {
        return $this->hasOne('App\Models\UsersBankDetails', 'user_id','id');
    }
    public function insurances()
    {
        return $this->hasOne('App\Models\UsersInsurances', 'user_id','id');
    }
    public function operatorRecords()
    {
        return $this->hasMany('App\Models\UsersOperatorsRecords', 'user_id','id');
    }
    public function complainceChecklist()
    {
        return $this->hasOne('App\Models\UsersComplianceChecklist', 'user_id','id');
    }
    public function equipmentChecklist()
    {
        return $this->hasOne('App\Models\UsersEquipmentChecklist', 'user_id','id');
    }
    public function requirementChecklist()
    {
        return $this->hasOne('App\Models\UsersRequirementChecklist', 'user_id','id');
    }
    public function hireChecklist()
    {
        return $this->hasOne('App\Models\UsersHireChecklist', 'user_id','id');
    }
    public function truckDetails()
    {
        return $this->hasMany('App\Models\UserTrucksDetails', 'user_id','id');
    }
    public function trailerDetails()
    {
        return $this->hasMany('App\Models\UserTrailerDetails', 'user_id','id');
    }
    public function plantDetails()
    {
        return $this->hasMany('App\Models\UserPlantDetails', 'user_id','id');
    }
    public function checklistFiles()
    {
        return $this->hasMany('App\Models\UsersChecklistFiles', 'user_id','id');
    }
}
