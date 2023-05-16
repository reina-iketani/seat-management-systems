<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ReservesController;

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

Route::get('/', [ReservesController::class, 'index']);
Route::get('/dashboard', [ReservesController::class, 'index'])->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';


Route::group(['middleware' => ['auth']], function () {                                    // 追記
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);     // 追記
    Route::post('/reserves', [ReservesController::class, 'store'])->name('reserves.store');
    Route::get('/reserves', [ReservesController::class, 'index'])->name('reserves.index');
    
});




Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
  Route::resource('users', UsersController::class);
});