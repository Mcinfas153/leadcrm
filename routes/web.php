<?php

use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\FreshLeads;
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
