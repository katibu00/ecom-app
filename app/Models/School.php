<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', // Add 'name' to the fillable property
        'username',
        'motto',
        'state',
        'lga',
        'address',
        'phone_first',
        'phone_second',
        'email',
        'website',
        'service_fee',
        'registrar_id',
        'logo',
        'admin_id',
    ];

    public function registrar(){
        return $this->belongsTo(User::class, 'registrar_id','id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id','id');
    }
    public function session(){
        return $this->belongsTo(Session::class, 'session_id','id');
    }
    public function result_settings(){
        return $this->hasOne(ResultSettings::class, 'school_id','id');
    }


    public function students()
    {
        return $this->hasMany(User::class)->where('usertype', 'std');
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function subjectAssignments()
    {
        return $this->hasManyThrough(
            AssignSubject::class,
            Classes::class,
            'school_id', 
            'class_id',
            'id', 
            'id' 
        );
    }


    public function feeCategories()
    {
        return $this->hasMany(FeeCategory::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    public function learningDomains()
    {
        return $this->hasMany(LearningDomain::class);
    }

    public function psychomotorSkills()
    {
        return $this->hasMany(PsychomotorCrud::class);
    }

    public function affectiveTraits()
    {
        return $this->hasMany(AffectiveCrud::class);
    }

    public function caSchemes()
    {
        return $this->hasMany(CAScheme::class);
    }

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    
}
