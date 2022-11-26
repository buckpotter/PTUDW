<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminBusesController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminRoutesController;
use App\Http\Controllers\AdminTicketsController;
use App\Http\Controllers\AdminStatisticsController;

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

Route::get('/', AdminHomeController::class)->middleware(['auth'])->name('home.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::resources([
    'tickets' => AdminTicketsController::class,
    'users' => AdminUsersController::class,
    'routes' => AdminRoutesController::class,
    'buses' => AdminBusesController::class
]);

Route::get('/statistics', AdminStatisticsController::class)->middleware('auth');
