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
    
}
