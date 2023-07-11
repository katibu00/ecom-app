<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function section(){
        return $this->belongsTo(Section::class, 'section_id','id');
    }
    public function form_master(){
        return $this->belongsTo(User::class, 'form_master_id','id');
    }
}
