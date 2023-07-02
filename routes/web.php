<?php

use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\ForgotPasswordPage;
use App\Http\Livewire\Pages\FreshLeads;
use App\Http\Livewire\Pages\LoginPage;
use App\Http\Livewire\Pages\RegisterPage;
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

Route::get('/', Dashboard::class)->name('dashboard');
Route::get('/recent-leads', FreshLeads::class)->name('freshleads');
Route::get('/login', LoginPage::class)->name('login');
Route::get('/register', RegisterPage::class)->name('register');
Route::get('/forgot-password', ForgotPasswordPage::class)->name('forgot-password');