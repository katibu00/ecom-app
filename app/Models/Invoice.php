<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function student(){
        return $this->belongsTo(User::class, 'student_id','id');
    }
    public function class(){
        return $this->belongsTo(Classes::class, 'class_id','id');
    }

    public function paymentSlip()
    {
        return $this->hasOne(PaymentSlip::class, 'invoice_id');
    }

    public function studentType()
    {
        return $this->belongsTo(StudentType::class, 'student_type');
    }


    public function feeCategories()
    {
        return $this->belongsToMany(FeeCategory::class, 'invoice_fee', 'invoice_id', 'fee_category_id');
    }


}
