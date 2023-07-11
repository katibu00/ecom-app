<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectOffering extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['subject_id', 'student_id','school_id', 'offering'];

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id','id');
    }

    public function class(){
        return $this->belongsTo(Classes::class, 'class_id','id');
    }

}
