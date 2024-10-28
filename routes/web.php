<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
});



Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');


Route::get('/admin/forgot_password', [AdminController::class, 'AdminForgotPassword'])->name('admin.forgot_password');

Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');



// Route::middleware('client')->group(function () {
//     Route::get('/client/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
//     Route::get('/client/profile', [ClientController::class, 'ClientProfile'])->name('client.profile');
//     Route::post('/client/profile/store', [ClientController::class, 'ClientProfileStore'])->name('client.profile.store');
//     Route::get('/client/change/password', [ClientController::class, 'ClientChangePassword'])->name('client.change.password');
//     Route::post('/client/password/update', [ClientController::class, 'ClientPasswordUpdate'])->name('client.password.update');
    
// }); 