<?php

use App\Http\Controllers\Accounting\ExpensesController;
use App\Http\Controllers\Accounting\FeeCollectionController;
use App\Http\Controllers\Accounting\InvoicesController;
use App\Http\Controllers\Accounting\PaymentsController;
use App\Http\Controllers\Accounting\ReportsController;
use App\Http\Controllers\Accounting\TrackPaymentsController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\EarlyYearsMarksEntryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntelliSAS\SchoolController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\Result\AdminResultController;
use App\Http\Controllers\Result\CommentsController;
use App\Http\Controllers\Result\PsychomotorGradeController;
use App\Http\Controllers\Result\PublishResultController;
use App\Http\Controllers\Settings\AffectiveCrudController;
use App\Http\Controllers\Settings\AssignSubjectsController;
use App\Http\Controllers\Settings\BankAccountsController;
use App\Http\Controllers\Settings\BasicSettingsController;
use App\Http\Controllers\Settings\CASchemeController;
use App\Http\Controllers\Settings\ClassesController;
use App\Http\Controllers\Settings\EarlyYearsCrudController;
use App\Http\Controllers\Settings\FeeCategoriesController;
use App\Http\Controllers\Settings\FeeStructuresController;
use App\Http\Controllers\Settings\PsychomotorCrudController;
use App\Http\Controllers\Settings\SectionsController;
use App\Http\Controllers\Settings\SessionsController;
use App\Http\Controllers\Settings\StudentTypeController;
use App\Http\Controllers\Settings\SubjectsController;
use App\Http\Controllers\Users\ParentsController;
use App\Http\Controllers\Users\StaffsController;
use App\Http\Controllers\Users\StudentsController;
use App\Http\Controllers\Users\SubjectOfferingController;
use App\Mail\ResetSchoolAdminPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if (auth()->check()) {
        if (auth()->user()->usertype == 'admin') {
            return redirect()->route('admin.home');
        }
        if (auth()->user()->usertype == 'intellisas') {
            return redirect()->route('intellisas.home');
        }

    };

    return redirect()->route('login');

})->middleware('guest');

Route::get('/home', function () {

    if (auth()->user()->usertype == 'admin') {
        return redirect()->route('admin.home');
    }
    if (auth()->user()->usertype == 'intellisas') {
        return redirect()->route('intellisas.home');
    }
    if (auth()->user()->usertype == 'parent') {
        return redirect()->route('parent.home');
    }

})->middleware('auth');

Route::get('/sendmail', function () {

    Mail::to('admin@demoschool.com')->send(new ResetSchoolAdminPassword());

    return 'sendd successfully';
});

// Route::middleware('tenant')->group(function() {
//     // routes
// });

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/change/password', [ChangePasswordController::class, 'changePasswordIndex'])->name('change.password');
Route::post('/change/password', [ChangePasswordController::class, 'changePasswordStore']);

///// Intellisas routes /////
// Route::middleware('tenant')->group(function () {

Route::group(['middleware' => ['auth', 'intellisas']], function () {
    Route::get('/intellisas/home', [HomeController::class, 'intellisas'])->name('intellisas.home');
});
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
});
Route::group(['middleware' => ['auth', 'parent']], function () {
    Route::get('/parent/home', [HomeController::class, 'parent'])->name('parent.home');
});

Route::group(['middleware' => ['auth', 'teachers']], function () {
    Route::get('/teacher/home', [HomeController::class, 'teacher'])->name('teacher.home');
});

Route::group(['prefix' => 'schools', 'middleware' => ['auth', 'intellisas']], function () {
    Route::get('/index', [SchoolController::class, 'index'])->name('schools.index');
    Route::get('/admin/register', [SchoolController::class, 'adminCreate'])->name('school.admin.create');
    Route::post('/admin/register', [SchoolController::class, 'adminStore']);
    Route::post('/update/{id}', [SchoolController::class, 'update'])->name('school.admin.update');
    Route::post('/service/{id}', [SchoolController::class, 'service'])->name('service.record');
    Route::get('/logs/index', [SchoolController::class, 'log_index'])->name('logs.index');

    Route::get('/admins_lists', [SchoolController::class, 'adminsIndex'])->name('admins.index');

    Route::post('/get-school-details', [SchoolController::class, 'getScholDetails'])->name('get-school-details');
});

Route::group(['prefix' => 'settings', 'middleware' => ['auth', 'managers']], function () {
    Route::get('/basic/index', [BasicSettingsController::class, 'index'])->name('settings.basic.index');
    Route::post('/basic/index', [BasicSettingsController::class, 'updateBasic']);

    Route::get('/basic/monnify/index', [BasicSettingsController::class, 'monnifyIndex'])->name('settings.monnify.index');
    Route::post('/basic/monnify/index', [BasicSettingsController::class, 'monnifyStore']);

    Route::get('/sessions/index', [SessionsController::class, 'index'])->name('settings.sessions.index');
    Route::post('/sessions/index', [SessionsController::class, 'store']);
    Route::post('/sessions/delete', [SessionsController::class, 'delete'])->name('settings.session.delete');
    Route::post('/sessions/update', [SessionsController::class, 'update'])->name('settings.session.update');

    Route::get('/classes/index', [ClassesController::class, 'index'])->name('settings.classes.index');
    Route::post('/classes/index', [ClassesController::class, 'store']);
    Route::post('/classes/update', [ClassesController::class, 'update'])->name('settings.class.update');
    Route::post('/classes/delete', [ClassesController::class, 'delete'])->name('settings.class.delete');

    Route::get('/sections/index', [SectionsController::class, 'index'])->name('settings.sections.index');
    Route::post('/sections/index', [SectionsController::class, 'store']);
    Route::post('/sections/update', [SectionsController::class, 'update'])->name('settings.section.update');
    Route::post('/sections/delete', [SectionsController::class, 'delete'])->name('settings.section.delete');

    Route::get('/subjects/index', [SubjectsController::class, 'index'])->name('settings.subjects.index');
    Route::post('/subjects/index', [SubjectsController::class, 'store']);
    Route::post('/subjects/update', [SubjectsController::class, 'update'])->name('settings.subject.update');
    Route::post('/subjects/delete', [SubjectsController::class, 'delete'])->name('settings.subject.delete');

    Route::get('/assign_subjects/index', [AssignSubjectsController::class, 'index'])->name('settings.assign_subjects.index');
    Route::post('/assign_subjects/index', [AssignSubjectsController::class, 'store']);
    Route::post('/assign_subjects/update', [AssignSubjectsController::class, 'update'])->name('settings.assign_subjects.update');
    Route::post('/assign_subjects/delete', [AssignSubjectsController::class, 'delete'])->name('settings.assign_subjects.delete');

    Route::get('/ca_scheme/index', [CASchemeController::class, 'index'])->name('settings.ca_scheme.index');
    Route::post('/ca_scheme/index', [CASchemeController::class, 'store']);
    Route::post('/ca_scheme/update', [CASchemeController::class, 'update'])->name('settings.ca_scheme.update');
    Route::post('/ca_scheme/delete', [CASchemeController::class, 'delete'])->name('settings.ca_scheme.delete');

    Route::get('/psychomotor_skills/index', [PsychomotorCrudController::class, 'index'])->name('settings.psychomotor_crud.index');
    Route::post('/psychomotor_skills/index', [PsychomotorCrudController::class, 'store']);
    Route::post('/psychomotor_skills/update', [PsychomotorCrudController::class, 'update'])->name('settings.psychomotor_crud.update');
    Route::post('/psychomotor_skills/delete', [PsychomotorCrudController::class, 'delete'])->name('settings.psychomotor_crud.delete');

    Route::get('/affective_traits/index', [AffectiveCrudController::class, 'index'])->name('settings.affective_crud.index');
    Route::post('/affective_traits/index', [AffectiveCrudController::class, 'store']);
    Route::post('/affective_traits/update', [AffectiveCrudController::class, 'update'])->name('settings.affective_crud.update');
    Route::post('/affective_traits/delete', [AffectiveCrudController::class, 'delete'])->name('settings.affective_crud.delete');

// Learning Domain routes
    Route::get('/learning_domains', [EarlyYearsCrudController::class, 'index'])->name('learning_domains.index');
    Route::post('/learning-domains', [EarlyYearsCrudController::class, 'store'])->name('learning_domains.store');
    Route::get('/learning-domains/{learning_domain}/edit', [EarlyYearsCrudController::class, 'edit'])->name('learning_domains.edit');
    Route::put('/learning-domains/{learning_domain}', [EarlyYearsCrudController::class, 'update'])->name('learning_domains.update');
    Route::delete('/learning-domains/{learning_domain}', [EarlyYearsCrudController::class, 'destroy'])->name('learning_domains.destroy');

// Learning Outcome routes
    Route::post('/learning-domains/{learning_domain}/learning-outcomes', [EarlyYearsCrudController::class, 'store'])->name('learning_outcomes.store');
    Route::delete('/learning-domains/{learning_domain}/learning-outcomes/{learning_outcome}', [EarlyYearsCrudController::class, 'destroy'])->name('learning_outcomes.destroy');

    Route::get('/fee_category/index', [FeeCategoriesController::class, 'index'])->name('settings.fee_category.index');
    Route::post('/fee_category/index', [FeeCategoriesController::class, 'store']);
    Route::post('/fee_category/update', [FeeCategoriesController::class, 'update'])->name('settings.fee_category.update');
    Route::post('/fee_category/delete', [FeeCategoriesController::class, 'delete'])->name('settings.fee_category.delete');

    Route::get('/student_type/index', [StudentTypeController::class, 'index'])->name('settings.student_type.index');
    Route::post('/student_type/index', [StudentTypeController::class, 'store']);
    Route::post('/student_type/update', [StudentTypeController::class, 'update'])->name('settings.student_type.update');
    Route::post('/student_type/delete', [StudentTypeController::class, 'delete'])->name('settings.student_type.delete');

    Route::get('/bank_accounts/index', [BankAccountsController::class, 'index'])->name('settings.banks.index');
    Route::post('/bank_accounts/index', [BankAccountsController::class, 'store']);
    Route::post('/bank_accounts/update', [BankAccountsController::class, 'update'])->name('settings.banks.update');
    Route::post('/bank_accounts/delete', [BankAccountsController::class, 'delete'])->name('settings.banks.delete');

    Route::get('/fee_structure/index', [FeeStructuresController::class, 'index'])->name('settings.fee_structure.index');
    Route::post('/fee_structure/index', [FeeStructuresController::class, 'store']);
    Route::post('/fee_structure/update', [FeeStructuresController::class, 'update'])->name('settings.fee_structure.update');
    Route::post('/fee_structure/details', [FeeStructuresController::class, 'details'])->name('settings.fee_structure.details');
    Route::post('/fee_structure/delete', [FeeStructuresController::class, 'delete'])->name('settings.fee_structure.delete');

    Route::get('/fee_structure/edit', [FeeStructuresController::class, 'edit'])->name('settings.fee_structure.edit');
    Route::post('/fee_structure/copy', [FeeStructuresController::class, 'copyFeeStructure'])->name('settings.fee_structure.copy');
    Route::post('fee_structure/change_term', [FeeStructuresController::class, 'changeTerm'])->name('settings.fee_structure.change_term');

});

Route::group(['prefix' => 'users', 'middleware' => ['auth', 'teachers']], function () {
    Route::get('/students/index', [StudentsController::class, 'index'])->name('users.students.index');
    Route::get('/students/create', [StudentsController::class, 'create'])->name('users.students.create');
    Route::post('/students/edit', [StudentsController::class, 'editStudent'])->name('users.students.edit');
    Route::post('/students/store', [StudentsController::class, 'store'])->name('users.students.store');
    Route::get('/students/sort', [StudentsController::class, 'sort'])->name('users.students.sort');
    Route::post('/students/search', [StudentsController::class, 'search'])->name('users.students.search');
    Route::post('/students/details', [StudentsController::class, 'details'])->name('users.students.details');
    Route::post('/get-student_details', [StudentsController::class, 'getStudentDetails'])->name('get-student_details');
    Route::post('/students/delete', [StudentsController::class, 'delete'])->name('students.delete');

    Route::get('/staffs/index', [StaffsController::class, 'index'])->name('users.staffs.index');
    Route::get('/staffs/create', [StaffsController::class, 'create'])->name('users.staffs.create');
    Route::post('/staffs/edit', [StaffsController::class, 'editStaff'])->name('users.staffs.edit');
    Route::post('/staffs/store', [StaffsController::class, 'store'])->name('users.staffs.store');
    Route::get('/staffs/sort', [StaffsController::class, 'sort'])->name('users.staffs.sort');
    Route::post('/staffs/search', [StaffsController::class, 'search'])->name('users.staffs.search');
    Route::post('/staffs/details', [StaffsController::class, 'details'])->name('users.staff.details');
    Route::post('/get-staff_details', [StaffsController::class, 'getStaffDetails'])->name('get-staff_details');

    Route::get('/parents/index', [ParentsController::class, 'index'])->name('users.parents.index');
    Route::get('/parents/create', [ParentsController::class, 'create'])->name('users.parents.create');
    Route::post('/parents/edit', [ParentsController::class, 'editParent'])->name('users.parents.edit');
    Route::post('/parents/store', [ParentsController::class, 'store'])->name('users.parents.store');
    Route::get('/parents/sort', [ParentsController::class, 'sort'])->name('users.parents.sort');
    Route::post('/parents/search', [ParentsController::class, 'search'])->name('users.parents.search');
    Route::post('/parents/details', [ParentsController::class, 'details'])->name('users.parents.details');
    Route::post('/get-parent_details', [ParentsController::class, 'getParentDetails'])->name('get-parent_details');

    Route::get('/subjects_offering/index', [SubjectOfferingController::class, 'index'])->name('subjects_offering.index');
    Route::post('/get-subjects_offering', [SubjectOfferingController::class, 'getSubjects'])->name('get-subjects_offering');
    Route::post('/save-subjects_offering', [SubjectOfferingController::class, 'saveSubjectsOffering'])->name('save-subjects_offering');

});

// Route::get('/paginate-students', [StudentsController::class, 'paginate']);
// Route::get('/users/students/sort', [StudentsController::class, 'sort']);

Route::group(['prefix' => 'marks', 'middleware' => ['auth', 'teachers']], function () {
    Route::get('/create', [MarksController::class, 'create'])->name('marks.create');
    Route::post('/create/fetch_students', [MarksController::class, 'getMarks'])->name('marks.create.fetch');
    Route::post('/initialize-marks-entry', [MarksController::class, 'initializeMarks'])->name('initialize-marks-entry');
    Route::post('/save-marks-entry', [MarksController::class, 'saveMarks'])->name('save-marks-entry');
    Route::post('/submit-marks-entry', [MarksController::class, 'submitMarks'])->name('submit-marks-entry');
    Route::post('/check-absent-marks-entry', [MarksController::class, 'checkAbsentMarks'])->name('check-absent-marks-entry');
    Route::post('/uncheck-absent-marks-entry', [MarksController::class, 'uncheckAbsentMarks'])->name('uncheck-absent-marks-entry');
    Route::get('/submissions/index', [MarksController::class, 'submissionIndex'])->name('marks.submissions.index');
    Route::post('/submissions/search', [MarksController::class, 'submissionSearch'])->name('marks.submissions.search');
    Route::get('/grade_book/index', [MarksController::class, 'gradeBookIndex'])->name('marks.grade_book.index');
    Route::post('/grade_book/search', [MarksController::class, 'gradeGookSearch'])->name('marks.grade_book.search');

    Route::get('/socio-emotional/index', [PsychomotorGradeController::class, 'index'])->name('psychomotor.index');
    Route::post('/get-psychomotor', [PsychomotorGradeController::class, 'getRecords'])->name('psychomotor.get');
    Route::post('/store-psychomotor', [PsychomotorGradeController::class, 'storePsychomotor'])->name('psychomotor.store');
    Route::get('/view-psychomotor/{class_id}/{type}', [PsychomotorGradeController::class, 'viewRecords'])->name('psychomotor.view');




    // Route to show the Early Years marks entry page
Route::get('/early-years/marks-entry', [EarlyYearsMarksEntryController::class,'index'])->name('early-years.marks-entry');
Route::get('/marks-entry/students-by-class/{classId}', [EarlyYearsMarksEntryController::class,'getStudentsByClass'])->name('marks-entry.students-by-class');
Route::get('/get-marks/{studentId}', [EarlyYearsMarksEntryController::class, 'getMarks'])->name('marks.getMarks');
Route::post('/early-year-marks', [EarlyYearsMarksEntryController::class, 'store'])->name('early_year_marks.store');



});

//termly result generation
Route::group(['prefix' => 'result', 'middleware' => ['auth', 'teachers']], function () {
    Route::get('/termly/index', [AdminResultController::class, 'termIndex'])->name('result.termly.index');
    Route::post('/termly/index', [AdminResultController::class, 'termGenerate']);

    Route::get('/settings/index', [AdminResultController::class, 'settingsIndex'])->name('result.settings');
    Route::post('/settings/index', [AdminResultController::class, 'settingsStore']);

    Route::get('/comments/index', [CommentsController::class, 'index'])->name('comments.index');
    Route::post('/get-comments', [CommentsController::class, 'getComments'])->name('comments.get');
    Route::post('/store-comments', [CommentsController::class, 'storeComments'])->name('comments.store');
    Route::post('/view-comments', [CommentsController::class, 'viewComments'])->name('comments.view');
    Route::post('/edit-comments', [CommentsController::class, 'editComments'])->name('comments.edit');

    Route::get('/publish/index', [PublishResultController::class, 'index'])->name('result.publish');

});

//fees and billing
Route::group(['prefix' => 'billing', 'middleware' => ['auth', 'managers']], function () {
    Route::get('/invoices/generate/index', [InvoicesController::class, 'index'])->name('invoices.index');
    Route::post('/get-students-invoices', [InvoicesController::class, 'getRecords'])->name('invoices.get.students');
    Route::post('/store-invoices', [InvoicesController::class, 'storeInvoices'])->name('invoices.store');
    Route::post('/update-invoices', [InvoicesController::class, 'updateInvoices'])->name('invoices.update');

    Route::get('/invoices/print/index', [InvoicesController::class, 'PrintIndex'])->name('invoices.print.index');
    Route::post('/invoices/print/generate', [InvoicesController::class, 'print'])->name('invoices.print.generate');
    Route::post('/invoices/bulk_action', [InvoicesController::class, 'bulk_action'])->name('invoices.bulk_action');

    Route::post('/invoices/sort', [InvoicesController::class, 'fetchData'])->name('invoices.sort');

    Route::get('/fee_collection/index', [FeeCollectionController::class, 'index'])->name('fee_collection.index');
    Route::post('/get-invoices', [FeeCollectionController::class, 'getInvoices'])->name('get-invoices');
    Route::post('/get-fees', [FeeCollectionController::class, 'getFees'])->name('get-fees');

    Route::post('/initialize-payment', [FeeCollectionController::class, 'InitializePayment'])->name('initialize-payment');
    Route::post('/record-payment', [FeeCollectionController::class, 'recordPayment'])->name('record-payment');
    Route::post('/refresh-table', [FeeCollectionController::class, 'refreshPayment'])->name('refresh-table');

    Route::get('/admin/generate/receipt/{id}', [FeeCollectionController::class, 'generateReceipt'])->name('admin.generate.receipt');

    Route::get('/expenses/index', [ExpensesController::class, 'index'])->name('expenses.index');
    Route::post('/expenses/index', [ExpensesController::class, 'store']);

    Route::get('/report/index', [ReportsController::class, 'index'])->name('billing.report.index');
    Route::post('/report/generate', [ReportsController::class, 'generate'])->name('billing.report.generate');

    Route::get('/payments/index', [PaymentsController::class, 'index'])->name('payments.index');

    Route::get('/track_payments', [TrackPaymentsController::class, 'index'])->name('track_payments');
    Route::post('/track_payments/sort', [TrackPaymentsController::class, 'sort'])->name('track_payments.sort');
    Route::post('/track_payments/invoice_details', [TrackPaymentsController::class, 'fetchInvoiceDetails'])->name('track_payments.invoice_details');
    Route::post('/track_payments/payment_history', [TrackPaymentsController::class, 'getPaymentHistory'])->name('track_payments.payment_history');
});

Route::group(['prefix' => 'attendance', 'middleware' => ['auth', 'teachers']], function () {

    Route::get('/take/index', [AttendanceController::class, 'create'])->name('attendance.take.index');
    Route::post('/take/search', [AttendanceController::class, 'create'])->name('attendance.take.search');
    Route::post('/take/store', [AttendanceController::class, 'store'])->name('attendance.take.store');

    Route::get('/overview/index', [AttendanceController::class, 'overview'])->name('attendance.overview');

    Route::post('/get-details', [AttendanceController::class, 'getDetails'])->name('attendance.get-details');

    Route::get('/report', [AttendanceController::class, 'report'])->name('attendance.report.index');
    Route::post('/report', [AttendanceController::class, 'report'])->name('attendance.report.search');

    Route::get('/offline/sheet/index', [AttendanceController::class, 'offline_index'])->name('attendance.offline.index');
    Route::post('/offline/sheet/generate', [AttendanceController::class, 'offline_generate'])->name('attendance.offline.generate');

});

Route::group(['prefix' => 'fees_billing', 'middleware' => ['auth', 'parent']], function () {

    Route::get('/index', [ParentController::class, 'feesIndex'])->name('fees_billing.index');
    Route::post('/mark_optional', [ParentController::class, 'markOptional'])->name('mark_optional');
    Route::post('/proceed_payment', [ParentController::class, 'proccedPayment'])->name('proceed_payment');

});

// });
