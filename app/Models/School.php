<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    public function registrar(){
        return $this->belongsTo(User::class, 'registrar_id','id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id','id');
    }
}
