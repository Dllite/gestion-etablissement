<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ConcourseController;
use App\Http\Controllers\ConcourseWriterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfostudentController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/qr', function (){
    return view('page.qr');
});

Route::post('/generate-invoice', [QrCodeController::class, 'generateInvoiceAndQrCode'])->name('generate.invoice');
Route::get('/generate-invoice', [QrCodeController::class, 'generateInvoiceAndQrCode'])->name('generate.invoice');

Route::middleware(['cors'])->group(function () {
    Route::get('/pay-concourse', [HomeController::class, 'payConcourse']);
    Route::post('/add-concourse-writer', [ConcourseWriterController::class, 'addConcourseWriters'])->name('add-concourse-writer');
    /**
     * Routes pour les paiements via giselpay
     */
    Route::post('/giselpay/init', [PaymentController::class, 'initPayment'])->name('payment.init');
    Route::post('/giselpay/check', [PaymentController::class, 'checkPayment'])->name('payment.check');

    // Route::post('/add-concourse-writer', 'ConcourseWriterController@addConcourseWriters');


    Route::group(['middleware' => 'auth'], function () {

        Route::get('/logout', [SessionsController::class, 'destroy']);
        Route::get('/user-profile', [InfoUserController::class, 'create']);
        Route::post('/user-profile', [InfoUserController::class, 'store']);
        Route::post('/change-password', [InfoUserController::class, 'changeUserPassword'])->name('change-password');

        Route::get('student-management', [StudentController::class, 'index'])->name('student-management');
        Route::get('view-student/{id}', [StudentController::class, 'viewStudent'])->name('view-student');

        Route::group(['middleware' => 'admin'], function () {
            Route::get('user-management', [UserController::class, 'index'])->name('user-management');
            Route::get('deleted-user-management', [UserController::class, 'deletedUser'])->name('deleted-user-management');
            Route::post('/add-user', [UserController::class, 'addUser'])->name('add-user');
            Route::get('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('delete-user');
            Route::get('user-restore-all', [UserController::class, 'restoreUsers'])->name('user-restore-all');
            Route::get('user-status/{id}/{status}', [UserController::class, 'changeUserStatus'])->name('change-user-status');

            Route::get('student-status/{id}/{status}', [StudentController::class, 'changeStudentStatus'])->name('change-student-status');
            Route::post('add-student-temp', [StudentController::class, 'addStudent'])->name('add-student-temp');

            Route::get('parent-management', [ParentController::class, 'index'])->name('parent-management');
            Route::post('/add-parent', [ParentController::class, 'addParent'])->name('add-parent');
            Route::post('/add-student-parent', [ParentController::class, 'addStudentParent'])->name('add-student-parent');
            Route::get('parent-status/{id}/{status}', [ParentController::class, 'changeParentStatus'])->name('change-parent-status');


            Route::get('concourse-writers', [ConcourseController::class, 'concourseWriters'])->name('concourse-writers');
            Route::get('/concourse-writer-status/{id}/{status}', [ConcourseWriterController::class, 'changeConcourseWriterStatus'])->name('concourse-writer-status');


            Route::get('classe-management', [ClasseController::class, 'index'])->name('classe-management');
            Route::post('/add-classe', [ClasseController::class, 'addClasse'])->name('add-classe');
            Route::get('classe-status/{id}/{status}', [ClasseController::class, 'changeClassesStatus'])->name('change-classe-status');
        });


        Route::group(['middleware' => 'controller'], function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        });


        Route::group(['middleware' => 'parent'], function () {
            Route::post('add-payment', [PaymentController::class, 'addPayment'])->name('add-payment');
        });
    });



    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [SessionsController::class, 'create']);
        Route::post('/session', [SessionsController::class, 'store']);
    });
});
