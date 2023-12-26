<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\QuestionPackageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ExamSessionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\QuestionAnswerController;
use App\Models\School;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/{name}',[HelloController::class,'index'])->name('hello.index');


Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/school', [SchoolController::class, 'index'])->name('school.index');
Route::get('/school/add', [SchoolController::class, 'form'])->name('school.form');
Route::post('/school/save', [SchoolController::class, 'simpan'])->name('school.insert');
Route::get('/school/edit/{id}', [SchoolController::class, 'formedit'])->name('school.form.edit');
Route::post('/school/update', [SchoolController::class, 'update'])->name('school.update');
Route::get('/school/delete/{id}', [SchoolController::class, 'delete'])->name('school.delete')->middleware('can:allow-delete-data-school');
Route::get('/school/export/xls', [SchoolController::class, 'unduhdata'])->name('school.export.xls');
Route::get('/school/export/{id}/docx', [SchoolController::class, 'cetakword'])->name('school.export.docx');
Route::get('/school/export/{id}/pdf', [SchoolController::class, 'cetakpdf'])->name('school.export.pdf');

Route::get('/role', [RoleController::class,'index'])->name('role.index');
Route::get('/role/add', [RoleController::class, 'form'])->name('role.form');
Route::post('/role/save', [RoleController::class,'simpan'])->name('role.insert');
Route::get('/role/edit/{id}', [RoleController::class,'formedit'])->name('role.form.edit');
Route::post('/role/update', [RoleController::class,'update'])->name('role.update');
Route::get('/role/delete/{id}', [RoleController::class,'delete'])->name('role.delete')->middleware('can:allow-delete-data-role');

Route::get('/exam', [QuestionPackageController::class, 'index'])->name('exam.index');
Route::get('/exam/create', [QuestionPackageController::class, 'create'])->name('exam.create');
Route::post('/exam', [QuestionPackageController::class, 'store'])->name('exam.store');
Route::get('/exam/{questionPackage}/edit', [QuestionPackageController::class, 'edit'])->name('exam.edit');
Route::patch('/exam/{questionPackage}', [QuestionPackageController::class, 'update'])->name('exam.update');
Route::delete('/exam/{questionPackage}', [QuestionPackageController::class, 'destroy'])->name('exam.destroy');

Route::get('/exam/{questionPackage}/questions', [QuestionController::class, 'index'])->name('question.index');
Route::get('/exam/{questionPackageId}/questions/create', [QuestionController::class, 'create'])->name('question.create');
Route::post('/exam/{questionPackageId}/questions', [QuestionController::class, 'store'])->name('question.store');
Route::put('/exam/questions/{question}', [QuestionController::class, 'update'])->name('question.update');
Route::delete('/exam/questions/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');

Route::get('/exam/start', [ExamSessionController::class, 'create'])->name('exam.start');
Route::post('/exam/start/{questionPackage}', [ExamSessionController::class, 'start'])->name('exam.start.session');
Route::get('/exam/session/{questionPackage}', [ExamSessionController::class, 'show'])->name('exam.session');
Route::post('/exam/submit/{questionPackage}', [ExamSessionController::class, 'submit'])->name('exam.submit');
Route::get('/exam/result/{questionPackage}', [ExamSessionController::class, 'result'])->name('exam.result');
Route::delete('/exam/result/delete/{result}', [ExamSessionController::class, 'deleteResult'])->name('exam.result.delete');




