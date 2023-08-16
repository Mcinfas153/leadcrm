<?php

use App\Classes\Automation\LeadReshuffle;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\Pages\AccountSettings;
use App\Http\Livewire\Pages\AddLead;
use App\Http\Livewire\Pages\AddUser;
use App\Http\Livewire\Pages\AllLeads;
use App\Http\Livewire\Pages\BusinessInactive;
use App\Http\Livewire\Pages\DailyUserReport;
use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\ForgotPasswordPage;
use App\Http\Livewire\Pages\FreshLeads;
use App\Http\Livewire\Pages\LeadActivities;
use App\Http\Livewire\Pages\LeadComments;
use App\Http\Livewire\Pages\LeadView;
use App\Http\Livewire\Pages\LoginPage;
use App\Http\Livewire\Pages\OldDataLeads;
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
    Route::middleware(['activeBusiness'])->group(function () {
        Route::middleware(['adminUser'])->group(function () {
            Route::get('/users', UsersList::class)->name('users');
            Route::get('/add-user', AddUser::class)->name('add.user');
            Route::get('/user/daily-report', DailyUserReport::class)->name('user.daily.report');
            Route::get('/user/report/{userId}/{period}', [ReportController::class, 'userReportExport'])->name('user.report.download');
            Route::get('/account-settings', AccountSettings::class)->name('settings');
        });
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/recent-leads', FreshLeads::class)->name('fresh.leads');
        Route::get('/leads', AllLeads::class)->name('leads');
        Route::get('/lead/add', AddLead::class)->name('add.lead');
        Route::get('/lead/view/{leadId}', LeadView::class)->name('lead.view');
        Route::get('/lead/comments/{leadId}', LeadComments::class)->name('lead.comments');
        Route::get('/lead/activities/{leadId}', LeadActivities::class)->name('lead.activities');
        Route::get('/cold/leads', OldDataLeads::class)->name('old-data.leads');
        Route::post('/import',[LeadController::class,'importLeads'])->name('import.leads');
        Route::get('/export-leads',[LeadController::class,'exportLeads'])->name('export-leads');
    });

    Route::get('/businss/inactive', BusinessInactive::class)->name('business.inactive')->middleware('inactiveBusiness');
});

Route::middleware(['guestUser'])->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('forgot-password');
});

//testting purposr only
Route::get('/test', function(){
    $lead = new LeadReshuffle;
    dd($lead());
});

