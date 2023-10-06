<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonnifyAPISetting extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'school_id',
        'enable_monnify',
        'secret_key',
        'public_key',
        'contract_code',
    ];

}
