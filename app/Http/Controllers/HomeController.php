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
use App\Models\Quote;
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

            $total_paid += PaymentRecord::select('amount')
                ->where('student_id', $child->id)
                ->where('school_id', $school_id)
                ->where('session_id', $data['school']->session_id)
                ->where('term', $data['school']->term)
                ->sum('amount');

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

    ///////////////////////////////

    public function admin()
    {
        $school = School::findOrFail(auth()->user()->school_id);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $lastMonth = ($currentMonth - 1 <= 0) ? 12 : $currentMonth - 1;

        $incomeRecords = PaymentRecord::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total_income')
        )
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '>=', $currentMonth - 5)
            ->groupBy('month')
            ->pluck('total_income', 'month')
            ->toArray();

        $expectedRevenueSum = $this->calculateExpectedRevenue($school);

        $totalStudents = $this->getUserCount($school, 'std');
        $totalParents = $this->getUserCount($school, 'parent');
        $totalStaff = $this->getUserCount($school, ['teacher', 'admin', 'accountant', 'proprietor', 'director', 'staff']);
        
        $fee_collected = $this->getAggregateAmount(PaymentRecord::class, $school);
        $total_expenses = $this->getAggregateAmount(Expense::class, $school);
        $invoices = Invoice::where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('school_id', $school->id)
            ->get();

        list($total_invoice, $total_discount, $total_pre_bal, $invoice_count) = $this->calculateInvoiceTotals($invoices);
        $classes = Classes::all();
        // ... Other calculations ...
        $totalCAs = $this->calculateTotalCAs($classes);
        $totalEnteredCAs = $this->calculateTotalEnteredCAs($classes, $school);
        $paymentSlips = $this->getPaymentSlips($school)->count(); // Define this function
        $monthlyIncomes = $this->getMonthlyIncomes($currentMonth, $currentYear, $school); // Define this function
        $revenueThisMonth = $this->getRevenueThisMonth($currentMonth, $currentYear, $school); // Define this function
        $upcomingBirthdays = $this->getUpcomingBirthdays($school);

        $payments = $this->getLastPayments($school);

        $randomQuote = Quote::inRandomOrder()->first();


       
    if ($school->session_id == null) {
        session()->flash('warning_message', 'Your session has not been set. Please set your session by clicking <a href="' . route('settings.sessions.index') . '">here</a>.');
    } elseif ($school->sections->isEmpty()) {
        session()->flash('warning_message', 'No sections have been added. Please add sections by clicking <a href="' . route('settings.sections.index') . '">here</a>.');
    } elseif ($classes->count() == 0) {
        session()->flash('warning_message', 'No classes have been added. Please add classes by clicking <a href="' . route('settings.classes.index') . '">here</a>.');
    } elseif ($school->subjects->isEmpty()) {
        session()->flash('warning_message', 'No subjects have been added. Please add subjects by clicking <a href="' . route('settings.subjects.index') . '">here</a>.');
    } elseif ($school->subjectAssignments->isEmpty()) {
        session()->flash('warning_message', 'No subjects have been assigned to classes. Please assign subjects to classes by clicking <a href="' . route('settings.assign_subjects.index') . '">here</a>.');
    } elseif ($school->feeCategories->isEmpty()) {
        session()->flash('warning_message', 'No fee categories have been added. Please add fee categories by clicking <a href="' . route('settings.fee_category.index') . '">here</a>.');
    } elseif ($school->learningDomains->isEmpty()) {
        session()->flash('warning_message', 'No learning domains have been added. Please add learning domains by clicking <a href="' . route('learning_domains.index') . '">here</a>.');
    } elseif ($school->psychomotorSkills->isEmpty()) {
        session()->flash('warning_message', 'No psychomotor skills have been added. Please add psychomotor skills by clicking <a href="' . route('settings.psychomotor_crud.index') . '">here</a>.');
    } elseif ($school->affectiveTraits->isEmpty()) {
        session()->flash('warning_message', 'No affective traits have been added. Please add affective traits by clicking <a href="' . route('settings.affective_crud.index') . '">here</a>.');
    } elseif ($school->caSchemes->isEmpty()) {
        session()->flash('warning_message', 'No CA schemes have been added. Please add CA schemes by clicking <a href="' . route('settings.ca_scheme.index') . '">here</a>.');
    } elseif ($school->feeStructures->isEmpty()) {
        session()->flash('warning_message', 'No fee structures have been added. Please add fee structures by clicking <a href="' . route('settings.fee_structure.index') . '">here</a>.');
    } elseif ($school->bankAccounts->isEmpty()) {
        session()->flash('warning_message', 'No bank accounts have been added. Please add bank accounts by clicking <a href="' . route('settings.banks.index') . '">here</a>.');
    }elseif ($school->students->isEmpty()) {
        session()->flash('warning_message', 'No students have been added. Please add students by clicking <a href="' . route('users.students.create') . '">here</a>.');
    }
        
        
        

        return view('home.admin', compact(
            'fee_collected', 'randomQuote', 'payments', 'totalEnteredCAs', 'totalCAs', 'paymentSlips', 'invoice_count',
            'expectedRevenueSum', 'total_expenses', 'total_invoice', 'total_discount', 'total_pre_bal', 'monthlyIncomes',
            'revenueThisMonth', 'totalStudents', 'totalParents', 'totalStaff', 'upcomingBirthdays','school'
        ));
    }


    public function getRevenueThisMonth($currentMonth, $currentYear, $school)
    {
        $revenueThisMonth = PaymentRecord::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('school_id', $school->id)
            ->sum('amount');

        return $revenueThisMonth;
    }

    public function getMonthlyIncomes($currentMonth, $currentYear, $school)
    {
        $monthlyIncomes = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthNumber = ($currentMonth - $i <= 0) ? $currentMonth - $i + 12 : $currentMonth - $i;
            $monthName = Carbon::create($currentYear, $monthNumber, 1)->format('M');

            $incomeRecord = PaymentRecord::select(DB::raw('SUM(amount) as total_income'))
                ->whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $monthNumber)
                ->where('school_id', $school->id)
                ->first();

            $monthlyIncomes[] = [
                'month_number' => $monthNumber,
                'month_name' => $monthName,
                'total_income' => $incomeRecord ? $incomeRecord->total_income : 0,
            ];
        }

        return $monthlyIncomes;
    }

    public function getPaymentSlips($school)
    {
        return PaymentSlip::where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('school_id', $school->id)
            ->get();
    }

    public function calculateTotalCAs($classes)
    {
        $totalCAs = 0;

        foreach ($classes as $class) {
            $assignedSubjects = $class->assignedSubjects;
            $caSchemes = CAScheme::where('class_id', 'LIKE', "%{$class->id}%")->get();

            // You may need to adjust this logic based on your actual data structure
            $totalCAs += $assignedSubjects->count() * $caSchemes->count();
        }

        return $totalCAs;
    }

    public function calculateExpectedRevenue($school)
    {
        $expectedRevenue = [];

        $allStudentIds = DB::table('users')
            ->where('usertype', 'std')
            ->pluck('id')
            ->toArray();

        foreach ($allStudentIds as $studentId) {
            $paymentSlip = PaymentSlip::where('student_id', $studentId)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->first();

            if ($paymentSlip) {
                $expectedRevenue[$studentId] = $paymentSlip->payable;
            } else {
                $invoice = Invoice::where('student_id', $studentId)
                    ->where('session_id', $school->session_id)
                    ->where('term', $school->term)
                    ->first();

                if ($invoice) {
                    $expectedRevenue[$studentId] = $invoice->amount + $invoice->pre_balance - $invoice->discount;
                } else {
                    $student = User::find($studentId);
                    $feeStructure = FeeStructure::where('class_id', $student->class_id)
                        ->where('term', $school->term)
                        ->where('student_type', 'r')
                        ->first();

                    if ($feeStructure) {
                        $expectedRevenue[$studentId] = $feeStructure->amount;
                    } else {
                        $expectedRevenue[$studentId] = 0;
                    }
                }
            }
        }

        return array_sum($expectedRevenue);
    }

    public function getUserCount($school, $usertypes, $exclude = false)
    {
        $query = User::where('school_id', $school->id)
            ->whereIn('usertype', (array) $usertypes);
    
        if ($exclude) {
            $query->whereNotIn('usertype', ['std', 'parent']);
        }
    
        return $query->count();
    }

    public function getAggregateAmount($modelClass, $school)
    {
        return $modelClass::where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('school_id', $school->id)
            ->sum('amount');
    }

    public function calculateInvoiceTotals($invoices)
    {
        $total_invoice = 0;
        $total_discount = 0;
        $total_pre_bal = 0;
        $invoice_count = count($invoices);

        foreach ($invoices as $invoice) {
            $total_invoice += $invoice->amount;
            $total_discount += $invoice->discount;
            $total_pre_bal += $invoice->pre_balance;
        }

        return [$total_invoice, $total_discount, $total_pre_bal, $invoice_count];
    }

    public function getUpcomingBirthdays($school)
    {
        $currentDate = Carbon::now();
        $upcomingBirthdays = [];

        $users = Profile::whereHas('user', function ($query) use ($school) {
            $query->where('school_id', $school->id);
        })->with('user')->get();

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
                    $upcomingBirthday = $userBirthdate->copy()->year($currentDate->year)->addYear();
                    $daysUntilBirthday = $currentDate->diffInDays($upcomingBirthday);
                }

                $age = $userBirthdate->diffInYears($currentDate);

                $upcomingBirthdays[] = [
                    'user' => $user,
                    'days_until_birthday' => $daysUntilBirthday,
                    'age' => $age,
                ];
            }
        }

        usort($upcomingBirthdays, function ($a, $b) {
            return $a['days_until_birthday'] - $b['days_until_birthday'];
        });

        $selectedUsers = array_slice($upcomingBirthdays, 0, 5);

        return $selectedUsers;
    }
    public function getLastPayments($school)
    {
        $lastPayments = PaymentRecord::where('term', $school->term)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $payments = [];

        foreach ($lastPayments as $paymentRecord) {
            $paymentSlip = PaymentSlip::where('student_id', $paymentRecord->student_id)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->first();

            if ($paymentSlip) {
                $totalPayable = $paymentSlip->payable;
                $totalPaid = $paymentSlip->paid;
                $currentPayment = $paymentRecord->amount;

                $progress = ($totalPaid + $currentPayment) / $totalPayable * 100;

                $payments[] = [
                    'student' => $paymentRecord->student,
                    'payable' => $totalPayable,
                    'total_paid' => $totalPaid,
                    'current_payment' => $currentPayment,
                    'progress' => $progress,
                ];
            }
        }

        return $payments;
    }

    public function calculateTotalEnteredCAs($classes, $school)
    {
        $totalEnteredCAs = 0;

        foreach ($classes as $class) {
            $assignedSubjects = $class->assignedSubjects;
            $caSchemes = CAScheme::where('class_id', 'LIKE', "%{$class->id}%")->get();

            $totalEnteredCAs += Mark::whereNotNull('type')
                ->where('class_id', $class->id)
                ->where('type', '!=', 'exam')
                ->where('school_id', $school->id)
                ->where('term', $school->term)
                ->where('session_id', $school->session_id)
                ->distinct(['class_id', 'type', 'subject_id'])
                ->count('type');
        }

        return $totalEnteredCAs;
    }

}
