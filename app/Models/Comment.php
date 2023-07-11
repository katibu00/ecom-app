<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function student(){
        return $this->belongsTo(User::class, 'student_id','id');
    }
    public $timestamps = false;

    // public function class(){
    //     return $this->belongsTo(Classes::class, 'class_id','id');
    // }
}
