<?php

use App\Http\Controllers\LeadController;
use App\Http\Livewire\Pages\AccountSettings;
use App\Http\Livewire\Pages\AllLeads;
use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\ForgotPasswordPage;
use App\Http\Livewire\Pages\FreshLeads;
use App\Http\Livewire\Pages\Leads;
use App\Http\Livewire\Pages\LeadView;
use App\Http\Livewire\Pages\LoginPage;
use App\Http\Livewire\Pages\RegisterPage;
use App\Http\Livewire\Pages\UsersList;
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
Route::middleware(['loggedUser'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/recent-leads', FreshLeads::class)->name('freshleads');
    Route::get('/leads', AllLeads::class)->name('leads');
    Route::get('/lead/view/{leadId}', LeadView::class)->name('leadview');
    //Route::get('/all-leads', [LeadController::class, 'getAllLeads'])->name('all.leads');
    Route::post('/import',[LeadController::class,'importLeads'])->name('import.leads');
    Route::get('/export-leads',[LeadController::class,'exportLeads'])->name('export-leads');
    Route::get('/account-settings', AccountSettings::class)->name('settings');
    Route::get('/users', UsersList::class)->name('users');
});

Route::middleware(['guestUser'])->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('forgot-password');
});

