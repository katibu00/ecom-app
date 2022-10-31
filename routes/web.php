<?php

use App\Http\Controllers\Accounting\ExpensesController;
use App\Http\Controllers\Accounting\FeeCollectionController;
use App\Http\Controllers\Accounting\InvoicesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntelliSAS\SchoolController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\Result\AdminResultController;
use App\Http\Controllers\Result\CommentsController;
use App\Http\Controllers\Result\PsychomotorGradeController;
use App\Http\Controllers\Settings\AffectiveCrudController;
use App\Http\Controllers\Settings\AssignSubjectsController;
use App\Http\Controllers\Settings\BasicSettingsController;
use App\Http\Controllers\Settings\CASchemeController;
use App\Http\Controllers\Settings\ClassesController;
use App\Http\Controllers\Settings\FeeCategoriesController;
use App\Http\Controllers\Settings\FeeStructuresController;
use App\Http\Controllers\Settings\PsychomotorCrudController;
use App\Http\Controllers\Settings\SectionsController;
use App\Http\Controllers\Settings\SessionsController;
use App\Http\Controllers\Settings\SubjectsController;
use App\Http\Controllers\Users\StudentsController;
use App\Jobs\ReetSchoolAdminPasswordJob;
use App\Mail\ResetSchoolAdminPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    if(auth()->check()){
        if(auth()->user()->usertype == 'admin'){
            return redirect()->route('admin.home');
        }
        if(auth()->user()->usertype == 'intellisas'){
            return redirect()->route('intellisas.home');
        }
       
    };

    return redirect()->route('login');
    
})->name('home');

Route::get('/sendmail', function () {

 
    Mail::to('admin@demoschool.com')->send(new ResetSchoolAdminPassword());

    return 'sendd successfully';
});

Route::middleware('tenant')->group(function() {
    // routes
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');


///// Intellisas routes /////
// Route::middleware('tenant')->group(function () {

    Route::group(['middleware' => ['auth', 'intellisas']], function () {
        Route::get('/intellisas/home', [HomeController::class, 'intellisas'])->name('intellisas.home');
    });
    Route::group(['middleware' => ['auth', 'admin']], function () {
        Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
    });

    Route::group(['prefix' => 'schools', 'middleware' => ['auth', 'intellisas']], function () {
        Route::get('/index', [SchoolController::class, 'index'])->name('schools.index');
        Route::get('/admin/register', [SchoolController::class, 'adminCreate'])->name('school.admin.create');
        Route::post('/admin/register', [SchoolController::class, 'adminStore']);
        Route::post('/update/{id}', [SchoolController::class, 'update'])->name('school.admin.update');
        Route::post('/service/{id}', [SchoolController::class, 'service'])->name('service.record');
        Route::get('/logs/index', [SchoolController::class, 'log_index'])->name('logs.index');

        Route::post('/get-school-details', [SchoolController::class, 'getScholDetails'])->name('get-school-details');
    });

    Route::group(['prefix' => 'settings', 'middleware' => ['auth', 'admin']], function () {
        Route::get('/basic/index', [BasicSettingsController::class, 'index'])->name('settings.basic.index');
        Route::post('/basic/index', [BasicSettingsController::class, 'updateBasic']);


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

        Route::get('/fee_category/index', [FeeCategoriesController::class, 'index'])->name('settings.fee_category.index');
        Route::post('/fee_category/index', [FeeCategoriesController::class, 'store']);
        Route::post('/fee_category/update', [FeeCategoriesController::class, 'update'])->name('settings.fee_category.update');
        Route::post('/fee_category/delete', [FeeCategoriesController::class, 'delete'])->name('settings.fee_category.delete');

        Route::get('/fee_structure/index', [FeeStructuresController::class, 'index'])->name('settings.fee_structure.index');
        Route::post('/fee_structure/index', [FeeStructuresController::class, 'store']);
        Route::post('/fee_structure/update', [FeeStructuresController::class, 'update'])->name('settings.fee_structure.update');
        Route::post('/fee_structure/details', [FeeStructuresController::class, 'details'])->name('settings.fee_structure.details');
        Route::post('/fee_structure/delete', [FeeStructuresController::class, 'delete'])->name('settings.fee_structure.delete');

    });

    Route::group(['prefix' => 'users', 'middleware' => ['auth','admin']], function(){
        Route::get('/students/index', [StudentsController::class, 'index'])->name('users.students.index');
        Route::get('/students/create', [StudentsController::class, 'create'])->name('users.students.create');
        Route::post('/students/store', [StudentsController::class, 'store'])->name('users.students.store');
        Route::post('/students/sort', [StudentsController::class, 'sort'])->name('users.students.sort');
        Route::post('/students/details', [StudentsController::class, 'details'])->name('users.students.details');
        Route::get('/students/bulk_update/index', [StudentsController::class, 'bulk_update'])->name('users.students.bulk_update.index');
        Route::post('/students/bulk_update/index', [StudentsController::class, 'bulk_update']);
        Route::post('/students/bulk_update/store', [StudentsController::class, 'bulk_store'])->name('users.students.bulk_update.store');

        Route::post('/get-subjects_not_offering', [StudentsController::class, 'get_subjects_offering'])->name('get-subjects_not_offering');
        Route::post('/save-subjects_not_offering', [StudentsController::class, 'save_subjects_offering'])->name('save-subjects_not_offering');
    });

    Route::group(['prefix' => 'marks', 'middleware' => ['auth', 'admin']], function(){
        Route::get('/create', [MarksController::class, 'create'])->name('marks.create');
        Route::post('/create',  [MarksController::class, 'getMarks']);
        Route::post('/initialize-marks-entry',  [MarksController::class, 'initializeMarks'])->name('initialize-marks-entry');
        Route::post('/save-marks-entry',  [MarksController::class, 'saveMarks'])->name('save-marks-entry');
        Route::post('/submit-marks-entry',  [MarksController::class, 'submitMarks'])->name('submit-marks-entry');
        Route::post('/check-absent-marks-entry',  [MarksController::class, 'checkAbsentMarks'])->name('check-absent-marks-entry');
        Route::post('/uncheck-absent-marks-entry',  [MarksController::class, 'uncheckAbsentMarks'])->name('uncheck-absent-marks-entry');
        Route::get('/submissions/index', [MarksController::class, 'submissionIndex'])->name('marks.submissions.index');
        Route::post('/submissions/index', [MarksController::class, 'submissionSearch']);
        Route::get('/grade_book/index', [MarksController::class, 'gradeBookIndex'])->name('marks.grade_book.index');
        Route::post('/grade_book/index', [MarksController::class, 'gradeGookSearch']);
    });
    //termly result generation
    Route::group(['prefix' => 'result', 'middleware' => ['auth', 'admin']], function(){
        Route::get('/termly/index', [AdminResultController::class, 'termIndex'])->name('result.termly.index');
        Route::post('/termly/index', [AdminResultController::class, 'termGenerate']);

        Route::get('/settings/index', [AdminResultController::class, 'settingsIndex'])->name('result.settings');
        Route::post('/settings/index', [AdminResultController::class, 'settingsStore']);
      
    });
    ///comments 
    Route::group(['prefix' => 'comments', 'middleware' => ['auth', 'admin']], function(){
        Route::get('/index', [CommentsController::class, 'index'])->name('comments.index');
        Route::post('/get-comments', [CommentsController::class, 'getComments'])->name('comments.get');
        Route::post('/store-comments', [CommentsController::class, 'storeComments'])->name('comments.store');
        Route::post('/view-comments', [CommentsController::class, 'viewComments'])->name('comments.view');
    });
    ///comments 
    Route::group(['prefix' => 'psychomotor', 'middleware' => ['auth', 'admin']], function(){
        Route::get('/index', [PsychomotorGradeController::class, 'index'])->name('psychomotor.index');
        Route::post('/get-psychomotor', [PsychomotorGradeController::class, 'getRecords'])->name('psychomotor.get');
        Route::post('/store-psychomotor', [PsychomotorGradeController::class, 'storePsychomotor'])->name('psychomotor.store');
        Route::post('/view-psychomotor', [PsychomotorGradeController::class, 'viewComments'])->name('psychomotor.view'); 
      
    });
    //fees and billing
    Route::group(['prefix' => 'billing', 'middleware' => ['auth', 'admin']], function(){
        Route::get('/invoices/index', [InvoicesController::class, 'index'])->name('invoices.index');
        Route::post('/get-students-invoices', [InvoicesController::class, 'getRecords'])->name('invoices.get.students');
        Route::post('/store-invoices', [InvoicesController::class, 'storeInvoices'])->name('invoices.store');
        // Route::post('/view-psychomotor', [PsychomotorGradeController::class, 'viewComments'])->name('psychomotor.view'); 


        Route::get('/fee_collection/index', [FeeCollectionController::class, 'index'])->name('fee_collection.index');
        Route::post('/get-invoices', [FeeCollectionController::class, 'getInvoices'])->name('get-invoices');
        Route::post('/get-fees', [FeeCollectionController::class, 'getFees'])->name('get-fees');

        Route::post('/initialize-payment', [FeeCollectionController::class, 'InitializePayment'])->name('initialize-payment');
        Route::post('/record-payment', [FeeCollectionController::class, 'recordPayment'])->name('record-payment');
        Route::post('/refresh-table', [FeeCollectionController::class, 'refreshPayment'])->name('refresh-table');

        Route::get('/admin/generate/receipt/{id}', [FeeCollectionController::class, 'generateReceipt'])->name('admin.generate.receipt');

        Route::get('/expenses/index', [ExpensesController::class, 'index'])->name('expenses.index');
        Route::post('/expenses/index', [ExpensesController::class, 'store']);

      
    });

// });
