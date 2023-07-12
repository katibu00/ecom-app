<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningDomain extends Model
{
    use HasFactory;

    public function learningOutcomes()
    {
        return $this->hasMany(LearningOutcome::class);
    }

    public $timestamps = false;

    protected $fillable = [
        'name',
        'school_id'
    ];

}
