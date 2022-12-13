<?php

use App\Http\Controllers\AdminBusCompaniesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminBusesController;
use App\Http\Controllers\AdminNormalUsersController;
use App\Http\Controllers\AdminRoutesController;
use App\Http\Controllers\AdminTicketsController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\AdminTripsController;

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
Route::get('/admin', AdminHomeController::class)->middleware(['auth'])->name('admin.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route::group(['nomal_user', 'middleware' => ['auth', 'verified']], function () {
//     Route::get('/normal_users', [AdminNormalUsersController::class, 'index'])->name('normal_users.index');
//     Route::get('/normal_users/create', [AdminNormalUsersController::class, 'create'])->name('normal_users.create');
//     Route::get('/normal_users/{IdUser}', [AdminNormalUsersController::class, 'show'])->name('normal_users.show');
//     Route::delete('/normal_users/{IdUser}', [AdminNormalUsersController::class, 'destroy'])->name('normal_users.destroy');
// });



Route::resources([
    'normal_users' => AdminNormalUsersController::class,
    'bus_companies' => AdminBusCompaniesController::class,
    'buses' => AdminBusesController::class,
    'trips' => AdminTripsController::class,
    // 'routes' => AdminRoutesController::class,
    // 'tickets' => AdminTicketsController::class,
]);

Route::get('/normal_users/search', [AdminNormalUsersController::class, 'search'])->name('normal_users.search');
