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
   
   

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class, 'class_id');
    }

    public function paymentRecords()
    {
        return $this->hasManyThrough(PaymentRecord::class, User::class, 'class_id', 'student_id');
    }

    public function formMaster()
    {
        return $this->belongsTo(User::class, 'form_master_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }


    public function assignedSubjects()
    {
        return $this->hasMany(AssignSubject::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'class_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }


/**
     * Calculate and get the marking progress for this class.
     *
    * @return float|int
    */
    public function getMarkingProgress()
    {
        $totalAssignedCAs = CAscheme::where('class_id', $this->id)->count(); // Assuming 'CAscheme' is the model representing the 'c_a_schemes' table

        if ($totalAssignedCAs === 0) {
            return 0;
        }

        $totalEnteredCAs = $this->marks()
            ->whereNotNull('type')
            ->select('type') // Select the 'type' field to group by it
            ->distinct() // Make sure we count distinct 'type' values
            ->count(); // Count the number of distinct 'type' values (considered as entered CAs)

        return round(($totalEnteredCAs / $totalAssignedCAs) * 100, 2);
    }


   /**
    * Calculate and get the fee collection progress for this class.
    *
    * @return float|int
    */
    public function getFeeCollectionProgress()
    {
        $totalExpectedFee = $this->feeStructures()->where('student_type', 'regular')->sum('amount'); // Assuming the feeStructures relationship exists
        $totalCollectedFee = $this->paymentRecords()->sum('paid_amount'); // Assuming the paymentRecords relationship exists

        if ($totalExpectedFee === 0) {
            return 0;
        }

        return round(($totalCollectedFee / $totalExpectedFee) * 100, 2);
    }


    public function marks()
    {
        return $this->hasManyThrough(Mark::class, User::class, 'class_id', 'student_id');
    }

}
