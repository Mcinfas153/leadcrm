<?php

namespace App\Http\Controllers;

use App\Exports\UserReportExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function userReportExport($userId, $period) 
    {
        $user = User::find($userId);
        return (new UserReportExport)->forUser($userId)->forPeriod($period)->download($user->name.'.xlsx');
    }
}
