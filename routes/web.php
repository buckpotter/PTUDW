<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\HeadAdminController;
use App\Http\Controllers\AdminBusesController;
use App\Http\Controllers\AdminTripsController;
use App\Http\Controllers\AdminNormalUsersController;
use App\Http\Controllers\AdminBusCompaniesController;
use App\Http\Controllers\AdminTicketDetailsController;
use App\Http\Controllers\AdminTicketsController;

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
Route::get('/admin/show', HeadAdminController::class)->middleware(['auth'])->name('admin.show');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'user' => Auth::user(),
        'Ten_NX' => Auth::user()->IdNX == NULL ? 'Quản trị viên hệ thống' : Auth::user()->busCompany->Ten_NX
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::resources([
    'normal_users' => AdminNormalUsersController::class,
    'bus_companies' => AdminBusCompaniesController::class,
    'buses' => AdminBusesController::class,
    'trips' => AdminTripsController::class,
    'tickets' => AdminTicketsController::class,
    'ticket_details' => AdminTicketDetailsController::class,
]);

Route::put('/ticket_details/{IdBanVe}/cancel', [AdminTicketDetailsController::class, 'cancel'])->name('ticket_details.cancel');
