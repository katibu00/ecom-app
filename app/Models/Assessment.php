<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class,'exam_id','id');
    }
}
