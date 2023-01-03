<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    use HasFactory;
   
    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id','id');
    }
    public function student(){
        return $this->belongsTo(User::class, 'student_id','id');
    }
    public function session(){
        return $this->belongsTo(Session::class, 'session_id','id');
    }
}
