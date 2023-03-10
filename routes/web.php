<?php

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
//    return view('welcome');
    return redirect(route('user.home'));
})->name('wellcome');

Auth::routes();

Route::get('/home', function () {
    return redirect(route('user.home'));
})->name('home');



Route::group(['middleware' => 'auth'], function () {

    Route::group(
        [
            'middleware' => 'is_admin',
            'prefix' => 'admin',
            'as' => 'admin.'
        ],
        function () {

            Route::get('feedbacks', [\App\Http\Controllers\Admin\FeedbachController::class, 'index'])->name('feedbacks.index');
            Route::get('feedbacks/{home?}', [\App\Http\Controllers\Admin\FeedbachController::class, 'index'])->name('home');
            Route::post('feedback/process/{id}', [\App\Http\Controllers\Admin\FeedbachController::class, 'process'])->name('feedbacks.process');
            Route::post('feedback/delete/{id}', [\App\Http\Controllers\Admin\FeedbachController::class, 'destroy'])->name('feedbacks.delete');

        });

    Route::group(
        [
            'middleware' => 'is_client',
            'as' => 'user.'
        ],
        function () {

            Route::get('feedbacks', [\App\Http\Controllers\Client\FeedbachController::class, 'create'])->name('feedbacks.index');
            Route::get('feedbacks/{home?}', [\App\Http\Controllers\Client\FeedbachController::class, 'create'])->name('home');
            Route::post('feedbacks', [\App\Http\Controllers\Client\FeedbachController::class, 'store'])->name('feedbacks.create');

        });

});



