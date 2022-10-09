<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignSubject extends Model
{
    use HasFactory;

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id','id');
    }

    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id','id');
    }

    public function class(){
        return $this->belongsTo(Classes::class, 'class_id','id');
    }

  
}
