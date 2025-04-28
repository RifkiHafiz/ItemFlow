<?php

use App\Livewire\Dashboard;
use App\Livewire\Loan;
use App\Livewire\Login;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('auth');


Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
