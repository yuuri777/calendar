<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    //カレンダー一覧
    Route::get('cal',[CalendarController::class,"index"])->name('cal.index');
    // 予定作成画面
    Route::get('/cal/create',[CalendarController::class,"create"])->name('cal.create');

    // 予定作成処理
    Route::post('/cal/store',[CalendarController::class,"store"])->name('cal.store');
    // 日付ごとの予定確認画面
    Route::get('cal/{id}/detail',[CalendarController::class,"detail"])->name('cal.detail');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
