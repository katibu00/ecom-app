<?php

namespace App\Http\Controllers;

use App\Models\AssignSubject;
use App\Models\Attendance;
use App\Models\CAScheme;
use App\Models\Classes;
use App\Models\Expense;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\Mark;
use App\Models\PaymentRecord;
use App\Models\PaymentSlip;
use App\Models\Profile;
use App\Models\ReservedAccount;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function intellisas()
    {
        return view('home.intellisas');
    }

    // public function admin()
    // {
    //     $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
    //     $data['fee_collected'] = PaymentRecord::select('paid_amount')->where('session_id', $school->session_id)
    //         ->where('term', $school->term)
    //         ->where('school_id', $school->id)
    //         ->sum('paid_amount');

    //     $data['total_expenses'] = Expense::select('amount')->where('session_id', $school->session_id)
    //         ->where('term', $school->term)
    //         ->where('school_id', $school->id)
    //         ->sum('amount');
    //     $invoices = Invoice::select('amount', 'discount', 'pre_balance')->where('session_id', $school->session_id)
    //         ->where('term', $school->term)
    //         ->where('school_id', $school->id)
    //         ->get();

    //     $data['total_invoice'] = 0;
    //     $data['total_discount'] = 0;
    //     $data['total_pre_bal'] = 0;
    //     foreach ($invoices as $invoice) {
    //         $data['total_invoice'] += $invoice->amount;
    //         $data['total_discount'] += $invoice->discount;
    //         $data['total_pre_bal'] += $invoice->pre_balance;
    //     }

    //     $data['payments'] = PaymentRecord::selectRaw('MONTH(created_at) as month, SUM(paid_amount) as total')
    //         ->where('school_id', $school->id)
    //         ->where('session_id', $school->session_id)
    //         ->groupBy('month')
    //         ->orderBy('month', 'asc')
    //         ->get();

    //     $attendance = Attendance::select(DB::raw('status, COUNT(*) as total'))
    //         ->where('term', $school->term)
    //         ->groupBy('status')
    //         ->get();
    //     $present = 0;
    //     $absent = 0;
    //     $leave = 0;
    //     foreach ($attendance as $row) {
    //         if ($row->status == 'present') {
    //             $present = $row->total;
    //         } else if ($row->status == 'absent') {
    //             $absent = $row->total;
    //         } else if ($row->status == 'leave') {
    //             $leave = $row->total;
    //         }
    //     }
    //     $total = $present + $absent + $leave;

    //     if ($total != 0) {
    //         $data['present_percent'] = round(($present / $total) * 100, 2);
    //         $data['absent_percent'] = round(($absent / $total) * 100, 2);
    //         $data['leave_percent'] = round(($leave / $total) * 100, 2);
    //     } else {
    //         $data['present_percent'] = 0;
    //         $data['absent_percent'] = 0;
    //         $data['leave_percent'] = 0;
    //     }

    //     $data['total'] = $total;

    //     $data['totalStudents'] = User::where('school_id', $school->id)
    //     ->where('usertype', 'std')
    //     ->count();

    // // Count the number of parents
    // $data['totalParents'] = User::where('school_id', $school->id)
    //     ->where('usertype', 'parent')
    //     ->count();

    // // Count the number of other staff (excluding students and parents)
    // $data['totalStaff'] = User::where('school_id', $school->id)
    //     ->whereNotIn('usertype', ['std', 'parent'])
    //     ->count();

    //     return view('home.admin', $data);
    // }

// public function admin()
// {
//     $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();
//     $data['fee_collected'] = PaymentRecord::select('paid_amount')->where('session_id', $school->session_id)
//         ->where('term', $school->term)
//         ->where('school_id', $school->id)
//         ->sum('paid_amount');

//     $data['total_expenses'] = Expense::select('amount')->where('session_id', $school->session_id)
//         ->where('term', $school->term)
//         ->where('school_id', $school->id)
//         ->sum('amount');

//     $invoices = Invoice::select('amount', 'discount', 'pre_balance')->where('session_id', $school->session_id)
//         ->where('term', $school->term)
//         ->where('school_id', $school->id)
//         ->get();

//     $data['total_invoice'] = 0;
//     $data['total_discount'] = 0;
//     $data['total_pre_bal'] = 0;
//     foreach ($invoices as $invoice) {
//         $data['total_invoice'] += $invoice->amount;
//         $data['total_discount'] += $invoice->discount;
//         $data['total_pre_bal'] += $invoice->pre_balance;
//     }

//     // $data['payments'] = PaymentRecord::selectRaw('MONTH(created_at) as month, SUM(paid_amount) as total')
//     //     ->where('school_id', $school->id)
//     //     ->where('session_id', $school->session_id)
//     //     ->groupBy('month')
//     //     ->orderBy('month', 'asc')
//     //     ->get();

//     $attendance = Attendance::select(DB::raw('status, COUNT(*) as total'))
//         ->where('term', $school->term)
//         ->groupBy('status')
//         ->get();

//     $present = 0;
//     $absent = 0;
//     $leave = 0;
//     foreach ($attendance as $row) {
//         if ($row->status == 'present') {
//             $present = $row->total;
//         } else if ($row->status == 'absent') {
//             $absent = $row->total;
//         } else if ($row->status == 'leave') {
//             $leave = $row->total;
//         }
//     }
//     $total = $present + $absent + $leave;

//     if ($total != 0) {
//         $data['present_percent'] = round(($present / $total) * 100, 2);
//         $data['absent_percent'] = round(($absent / $total) * 100, 2);
//         $data['leave_percent'] = round(($leave / $total) * 100, 2);
//     } else {
//         $data['present_percent'] = 0;
//         $data['absent_percent'] = 0;
//         $data['leave_percent'] = 0;
//     }

//     $data['total'] = $total;

//           $data['totalStudents'] = User::where('school_id', $school->id)
//         ->where('usertype', 'std')
//         ->count();

//     // Count the number of parents
//     $data['totalParents'] = User::where('school_id', $school->id)
//         ->where('usertype', 'parent')
//         ->count();

//     // Count the number of other staff (excluding students and parents)
//     $data['totalStaff'] = User::where('school_id', $school->id)
//         ->whereNotIn('usertype', ['std', 'parent'])
//         ->count();

//     // Get chart data
//     $chartData = $this->getChartData($school->id, $school->session_id, $school->term);
//     $data['chartData'] = $chartData;

//     return view('home.admin', $data);
// }

// Add this method to your controller to fetch chart data
// public function getChartData($schoolId, $sessionId, $term)
// {
//     $currentYear = date('Y');
//     $currentMonth = date('m');
//     $months = [];
//     $expenseData = [];
//     $paymentData = [];

//     // Get expense data for the last 6 months of the current year
//     for ($i = 6; $i >= 1; $i--) {
//         $currentMonthFormatted = str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
//         $month = date('F', strtotime("$currentYear-$currentMonthFormatted-01"));
//         $months[] = $month;

//         // Get the first day of the current month
//         $startDate = "$currentYear-$currentMonthFormatted-01";
//         // Get the last day of the current month
//         $endDate = date('Y-m-t', strtotime($startDate));
//         $expenses = Expense::whereBetween('date', [$startDate, $endDate])
//             ->where('school_id', $schoolId)
//             ->where('session_id', $sessionId)
//             ->where('term', $term)
//             ->sum('amount');
//         $expenseData[] = $expenses;

//         $currentMonth--;
//         if ($currentMonth < 1) {
//             $currentMonth = 12;
//             $currentYear--;
//         }
//     }

//     // Get payment data for the last 6 months of the current year
//     $currentYear = date('Y');
//     $currentMonth = date('m');
//     for ($i = 6; $i >= 1; $i--) {
//         $currentMonthFormatted = str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
//         $month = date('F', strtotime("$currentYear-$currentMonthFormatted-01"));
//         // Ensure that the month is not duplicated in the months array
//         if (!in_array($month, $months)) {
//             $months[] = $month;
//         }

//         // Get the first day of the current month
//         $startDate = "$currentYear-$currentMonthFormatted-01";
//         // Get the last day of the current month
//         $endDate = date('Y-m-t', strtotime($startDate));

//         $payments = PaymentRecord::whereBetween('created_at', [$startDate, $endDate])
//             ->where('school_id', $schoolId)
//             ->where('session_id', $sessionId)
//             ->where('term', $term)
//             ->sum('paid_amount');
//         $paymentData[] = $payments;

//         $currentMonth--;
//         if ($currentMonth < 1) {
//             $currentMonth = 12;
//             $currentYear--;
//         }
//     }

//     return [
//         'months' => $months,
//         'expenseData' => $expenseData,
//         'paymentData' => $paymentData,
//     ];
// }

    public function parent()
    {
        $school_id = auth()->user()->school_id;
        $data['school'] = School::select('id', 'term', 'session_id', 'username')->where('id', $school_id)->first();

        $data['children'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id', 'image')
            ->where('parent_id', auth()->user()->id)
            ->where('school_id', $school_id)
            ->get();

        $total_amount_due = 0;
        $total_discount = 0;
        $total_pre_balance = 0;
        $total_paid = 0;

        foreach ($data['children'] as $child) {
            $paymentSlip = PaymentSlip::select('payable', 'discount', 'paid', 'invoice_id')
                ->where('student_id', $child->id)
                ->where('school_id', $school_id)
                ->where('session_id', $data['school']->session_id)
                ->where('term', $data['school']->term)
                ->first();
            if ($paymentSlip) {
                $total_amount_due += $paymentSlip->payable;
                $pre_balance = Invoice::select('pre_balance')->where('id', $paymentSlip->invoice_id)->first();
                $total_discount += $paymentSlip->discount;
                $total_pre_balance += @$pre_balance->pre_balance;
            } else {
                $invoice = Invoice::select('amount', 'discount', 'pre_balance')
                    ->where('student_id', $child->id)
                    ->where('school_id', $school_id)
                    ->where('session_id', $data['school']->session_id)
                    ->where('term', $data['school']->term)
                    ->first();
                if ($invoice) {
                    $total_amount_due += $invoice->amount;
                    $total_discount += $invoice->discount;
                    $total_pre_balance += $invoice->pre_balance;
                }

            }

            $total_paid += PaymentRecord::select('paid_amount')
                ->where('student_id', $child->id)
                ->where('school_id', $school_id)
                ->where('session_id', $data['school']->session_id)
                ->where('term', $data['school']->term)
                ->sum('paid_amount');

        }
        $data['total_amount_due'] = $total_amount_due;
        $data['total_discount'] = $total_discount;
        $data['total_pre_balance'] = $total_pre_balance;
        $data['total_paid'] = $total_paid;

        $query = ReservedAccount::where('user_id', auth()->user()->id)->first();

        if ($query) {
            $data['accounts'] = json_decode($query->accounts, true);
        } else {
            $data['accounts'] = [];
        }

        return view('home.parent', $data);
    }
    public function teacher()
    {
        $user = auth()->user();
        $data['school'] = School::select('id', 'term', 'session_id', 'username')->where('id', $user->school_id)->first();

        $data['classes'] = Classes::select('name', 'id')->where('form_master_id', $user->id)->get();

        $data['subjects'] = AssignSubject::select('subject_id', 'id', 'designation', 'class_id')->where('teacher_id', $user->id)->with('subject', 'class')->get();

        $data['students'] = 0;
        $data['attendance'] = 'no';
        foreach ($data['classes'] as $class) {
            $data['students'] += User::select('id')->where('class_id', $class->id)->count();
            $attendance = Attendance::select('id')->where('class_id', $class->id)->whereDate('created_at', Carbon::today())->first();
            if ($attendance) {
                $data['attendance'] = 'yes';
            }
        }

        return view('home.teacher', $data);
    }

    public function accountant()
    {
        $user = auth()->user();
        $data['school'] = School::select('id', 'term', 'session_id', 'username')->where('id', $user->school_id)->first();

        $data['classes'] = Classes::select('name', 'id')->where('form_master_id', $user->id)->get();

        $data['subjects'] = AssignSubject::select('subject_id', 'id', 'designation', 'class_id')->where('teacher_id', $user->id)->with('subject', 'class')->get();

        $data['students'] = 0;
        $data['attendance'] = 'no';
        foreach ($data['classes'] as $class) {
            $data['students'] += User::select('id')->where('class_id', $class->id)->count();
            $attendance = Attendance::select('id')->where('class_id', $class->id)->whereDate('created_at', Carbon::today())->first();
            if ($attendance) {
                $data['attendance'] = 'yes';
            }
        }

        return view('home.accountant', $data);
    }

    public function admin()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = ($currentMonth - 1 <= 0) ? 12 : $currentMonth - 1;

        // Calculate the last 6 months from the current month
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = [
                'month_number' => ($currentMonth - $i <= 0) ? $currentMonth - $i + 12 : $currentMonth - $i,
                'month_name' => Carbon::create($currentYear, $currentMonth - $i, 1)->format('M'),
            ];
        }

        $monthlyIncomes = [];
        for ($i = 0; $i < 6; $i++) {
            $monthNumber = $currentMonth - $i <= 0 ? $currentMonth - $i + 12 : $currentMonth - $i;
            $monthlyIncomes[$monthNumber] = 0;
        }

        // Fetch the actual income values from the database and update the $monthlyIncomes array
        $incomeRecords = PaymentRecord::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(paid_amount) as total_income')
        )
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '>=', $currentMonth - 5) // Fetch data for last 6 months
            ->groupBy('month')
            ->pluck('total_income', 'month')
            ->toArray();

        // Update $monthlyIncomes array with the actual income values from the database
        foreach ($incomeRecords as $month => $income) {
            $monthlyIncomes[$month] = $income;
        }

        // dd($monthlyIncomes);

        $revenueThisMonth = PaymentRecord::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('paid_amount');

        // Get revenue for last month
        $revenueLastMonth = PaymentRecord::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $lastMonth)
            ->sum('paid_amount');

        // Calculate percentage increase or decrease
        $percentageChange = 0;
        if ($revenueLastMonth != 0) {
            $percentageChange = (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100;
        }

        /////////////////////////

        $school = School::where('id', auth()->user()->school_id)->first();

// Assuming you have the current term and other necessary variables defined.

// Get the list of all student IDs in the school
        $allStudentIds = DB::table('users')
            ->where('usertype', 'std')
            ->pluck('id')
            ->toArray();

// Calculate Expected Revenue for each student
        $expectedRevenue = [];

        foreach ($allStudentIds as $studentId) {
            // Check for payment slip
            $paymentSlip = PaymentSlip::where('student_id', $studentId)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->first();

            if ($paymentSlip) {
                // Payment slip exists, use payable amount from payment slip
                $expectedRevenue[$studentId] = $paymentSlip->payable;
            } else {
                // Payment slip doesn't exist, check for invoice
                $invoice = Invoice::where('student_id', $studentId)
                    ->where('session_id', $school->session_id)
                    ->where('term', $school->term)
                    ->first();

                if ($invoice) {
                    // Invoice exists, use amount from invoice
                    $expectedRevenue[$studentId] = $invoice->amount + $invoice->pre_balance - $invoice->discount;
                } else {
                    // Invoice doesn't exist, use fee structure of the student class for that term
                    $student = User::find($studentId); // Assuming the User model represents the students
                    $feeStructure = FeeStructure::where('class_id', $student->class_id)
                        ->where('term', $school->term)
                        ->where('student_type', 'r')
                        ->first();

                    if ($feeStructure) {
                        // Fee structure exists, use amount from fee structure
                        $expectedRevenue[$studentId] = $feeStructure->amount;
                    } else {
                        // No fee structure found, set expected revenue to zero
                        $expectedRevenue[$studentId] = 0;
                    }
                }
            }
        }
        $expectedRevenueSum = array_sum($expectedRevenue);

        $totalStudents = User::where('school_id', $school->id)
            ->where('usertype', 'std')
            ->count();

        // Count the number of parents
        $totalParents = User::where('school_id', $school->id)
            ->where('usertype', 'parent')
            ->count();

        // Count the number of other staff (excluding students and parents)
        $totalStaff = User::where('school_id', $school->id)
            ->whereNotIn('usertype', ['std', 'parent'])
            ->count();



         $fee_collected = PaymentRecord::select('paid_amount')->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('school_id', $school->id)
            ->sum('paid_amount');

        $total_expenses = Expense::select('amount')->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('school_id', $school->id)
            ->sum('amount');
        $invoices = Invoice::select('amount', 'discount', 'pre_balance')->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('school_id', $school->id)
            ->get();

        $total_invoice = 0;
        $total_discount = 0;
        $total_pre_bal = 0;
        $invoice_count = 0;
        foreach ($invoices as $invoice) {
            $total_invoice += $invoice->amount;
            $total_discount += $invoice->discount;
            $total_pre_bal += $invoice->pre_balance;
            $invoice_count++;
        }


        $paymentSlips = PaymentSlip::select('id')->where('session_id', $school->session_id)
                                ->where('term', $school->term)
                                ->where('school_id', $school->id)
                                ->count();
      
/////////////////////////////////////////////



$classes = Classes::all();

$totalCAs = 0;
$totalEnteredCAs = 0;

foreach ($classes as $class) {

    $assignedSubjects = $class->assignedSubjects;
    $caSchemes = CAScheme::where('class_id', 'LIKE', "%{$class->id}%")->get();
    // dump($caSchemes);

    $totalCAs += $assignedSubjects->count() * $caSchemes->count();


    $totalEnteredCAs += Mark::whereNotNull('type')
                ->where('class_id', $class->id)
                ->where('type', '!=', 'exam')
                ->where('school_id', $school->id)
                ->where('session_id', $school->session_id)
                ->distinct(['class_id', 'type','subject_id'])
                ->count('type');

    // dump($totalEnteredCAs);

}



///////






    // Fetch users in the school of the authenticated user
    $schoolId = auth()->user()->school_id;

    $users = Profile::whereHas('user', function ($query) use ($schoolId) {
        $query->where('school_id', $schoolId);
    })->with('user')->get();

    $currentDate = Carbon::now();

    $upcomingBirthdays = [];

    foreach ($users as $user) {
        if ($user->dob !== null) {
            $userBirthdate = Carbon::createFromFormat('Y-m-d', $user->dob);

            $userDayMonth = $userBirthdate->format('m-d');
            $currentDayMonth = $currentDate->format('m-d');

            if ($userDayMonth === $currentDayMonth) {
                $daysUntilBirthday = 0;
            } elseif ($userDayMonth > $currentDayMonth) {
                $upcomingBirthday = $userBirthdate->copy()->year($currentDate->year);
                $daysUntilBirthday = $currentDate->diffInDays($upcomingBirthday);
            } else {
                $upcomingBirthday = $userBirthdate->copy()->year($currentDate->year);
                $daysUntilBirthday = $currentDate->diffInDays($upcomingBirthday);
            }

            $age = $userBirthdate->diffInYears($currentDate);

            $upcomingBirthdays[] = [
                'user' => $user,
                'days_until_birthday' => $daysUntilBirthday,
                'age' => $age,
            ];
        } else {
            // Handle the case where dob is null
            // For example, you might want to skip this user or handle it differently
        }
    }

    usort($upcomingBirthdays, function ($a, $b) {
        return $a['days_until_birthday'] - $b['days_until_birthday'];
    });

    $selectedUsers = array_slice($upcomingBirthdays, 0, 5);

// dd($selectedUsers);

// Now you have the $expectedRevenue array containing the expected revenue for each student in the school for the current term.

        /////////////////////////

        return view('home.admin', compact('fee_collected','selectedUsers','totalEnteredCAs','totalCAs','paymentSlips','invoice_count','expectedRevenueSum','total_expenses','total_invoice','total_discount','total_pre_bal','monthlyIncomes', 'months', 'revenueThisMonth', 'percentageChange','totalStudents','totalParents','totalStaff'));
    }

}
