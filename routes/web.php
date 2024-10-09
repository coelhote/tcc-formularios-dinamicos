<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResponseController;
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

Route::get('/', [FormController::class, 'homePage'])->name('home');

/** Question **/
Route::get('/form/question/create', [QuestionController::class, 'formQuestion'])->name('questions.create');
Route::get('/form/question/list', [QuestionController::class, 'getAllList'])->name('questions.list');
Route::get('/form/question/{id}/edit', [QuestionController::class, 'editQuestion'])->name('questions.edit');
Route::post('/form/question/{id}/delete', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::get('/form/question/index', [QuestionController::class, 'index'])->name('questions.index');
Route::resource('/question', QuestionController::class);

/** Form **/
Route::get('/form/form/create', [FormController::class, 'formForm'])->name('forms.create');
Route::get('/form/form/list', [FormController::class, 'index'])->name('forms.list');
Route::get('/form/protocol/{protocol}', [FormController::class, 'protocol'])->name('forms.protocol');
Route::get('/form/form/{id}/edit', [FormController::class, 'editForm'])->name('forms.edit');
Route::get('/form/response/{id}/{protocol}', [FormController::class, 'response'])->name('forms.response');
Route::post('/form/form/{id}/delete', [FormController::class, 'destroy'])->name('forms.destroy');
Route::resource('/form', FormController::class);
Route::get('/form/form/protocol/{protocol}', function () {
    return view('form-protocol');
});

/** Response **/
Route::resource('/response', ResponseController::class);

Route::get('/login', function () {
    return view('welcome');
})->name('login');
