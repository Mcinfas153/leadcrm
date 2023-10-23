<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\Pages\AccountSettings;
use App\Http\Livewire\Pages\ActiveLeadsPage;
use App\Http\Livewire\Pages\AddLead;
use App\Http\Livewire\Pages\AddUser;
use App\Http\Livewire\Pages\AgentCommision;
use App\Http\Livewire\Pages\AllLeads;
use App\Http\Livewire\Pages\BusinessInactive;
use App\Http\Livewire\Pages\CloseDeals;
use App\Http\Livewire\Pages\DailyUserReport;
use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\DumpLeadsPage;
use App\Http\Livewire\Pages\ForgotPasswordPage;
use App\Http\Livewire\Pages\FreshLeads;
use App\Http\Livewire\Pages\LeadActivities;
use App\Http\Livewire\Pages\LeadComments;
use App\Http\Livewire\Pages\LeadEntries;
use App\Http\Livewire\Pages\LeadView;
use App\Http\Livewire\Pages\LoginPage;
use App\Http\Livewire\Pages\OldCrmLeads;
use App\Http\Livewire\Pages\OldDataLeads;
use App\Http\Livewire\Pages\RegisterPage;
use App\Http\Livewire\Pages\Reminders;
use App\Http\Livewire\Pages\ResetCodeConfirmation;
use App\Http\Livewire\Pages\ResetPassword;
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
            Route::get('/user/add', AddUser::class)->name('add.user');
            Route::get('/user/daily-report/{userId?}', DailyUserReport::class)->name('user.daily.report');
            Route::get('/user/report/{userId}/{period}', [ReportController::class, 'userReportExport'])->name('user.report.download');
            Route::get('/close-lead/{leadId}', CloseDeals::class)->name('close-leads');
            Route::get('/agent-commisions', AgentCommision::class)->name('agent.commsions');
            Route::post('/agent-performance-chart',[ReportController::class, 'agentPerformanceChart']);
        });
        Route::get('/', Dashboard::class)->name('dashboard');
        Route::get('/download-leads', FreshLeads::class)->name('fresh.leads');
        Route::get('/leads', AllLeads::class)->name('leads');
        Route::get('/lead/add', AddLead::class)->name('add.lead');
        Route::get('/lead/view/{leadId}', LeadView::class)->name('lead.view');
        Route::get('/lead/comments/{leadId}', LeadComments::class)->name('lead.comments');
        Route::get('/lead/activities/{leadId}', LeadActivities::class)->name('lead.activities');
        Route::get('/cold/leads', OldDataLeads::class)->name('old-data.leads');
        Route::get('/active-leads', ActiveLeadsPage::class)->name('active.leads');
        Route::get('/dump-leads', DumpLeadsPage::class)->name('dump.leads');
        Route::get('/old-leads', OldCrmLeads::class)->name('old.crm.leads');
        Route::post('/import',[LeadController::class,'importLeads'])->name('import.leads');
        Route::post('/import/old-crm-leads',[LeadController::class,'importOldCrmLeads'])->name('import.oldcrm.leads');
        Route::get('/export-leads/{leadType?}',[LeadController::class,'exportLeads'])->name('export-leads');
        Route::get('/account-settings', AccountSettings::class)->name('settings');
        Route::get('/reminders', Reminders::class)->name('reminders');
        Route::get('/lead/{leadId}/entries', LeadEntries::class)->name('lead.entries');
        Route::get('/reset-password', ResetPassword::class)->name('reset-password');
    });

    Route::get('/businss/inactive', BusinessInactive::class)->name('business.inactive')->middleware('inactiveBusiness');
});

Route::middleware(['guestUser'])->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
    Route::get('/forgot-password', ForgotPasswordPage::class)->name('forgot-password');
    Route::get('/reset-code-confirmation', ResetCodeConfirmation::class)->name('user.reset-code-confirmation');
});

//testting purposr only
// Route::get('/test', function(){
//     NotificationTrait::push(3, "test", "https://facebook.com");
// });

