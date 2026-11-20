<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
 
Route::middleware('guest')->group(function () {
 
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');
 
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
 
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
 
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});
 
Route::middleware('auth')->group(function () {
 
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    Route::get('/profil', function () {
 
    return view('profile.index');
 
})->name('profile');
    
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});