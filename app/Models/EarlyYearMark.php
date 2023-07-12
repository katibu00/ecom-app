<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarlyYearMark extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'learning_outcome_id', 'grade', 'term', 'session_id', 'school_id'];

}
