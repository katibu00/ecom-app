<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningOutcome extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'learning_domain_id',
        'school_id'
    ];
}
