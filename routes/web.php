<?php

use App\Livewire\Dashboard;
use App\Livewire\Loan;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\UserManagement;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/assign-operator', function() {
    auth()->user()->assignRole('operator');
    return 'Anda sekarang operator!';
});

Route::get('/assign-admin', function() {
    auth()->user()->assignRole('admin');
    return 'Anda sekarang admin!';
});

Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('auth');

Route::get('/user-management', UserManagement::class)->name('user-management')->middleware('auth');

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
