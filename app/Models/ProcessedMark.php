<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessedMark extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function student(){
        return $this->belongsTo(User::class, 'student_id','id');
    }

    public function class(){
        return $this->belongsTo(Classes::class, 'class_id','id');
    }
}
