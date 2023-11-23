<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, RevisionableTrait;

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
        'user_type',
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userProfile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id','id');
    }

    public function revisions()
    {
        return $this->hasMany(\Venturecraft\Revisionable\Revision::class);
    }
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
