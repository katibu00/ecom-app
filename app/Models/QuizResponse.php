<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'school_id',
        'exam_id',
        'question_id',
        'response',
        'is_correct',
        'attempt_count',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    
}
