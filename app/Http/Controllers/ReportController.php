<?php

namespace App\Http\Controllers;

use App\Exports\UserReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function userReportExport($userId, $period) 
    {
        return (new UserReportExport)->forUser($userId)->forPeriod($period)->download('user-report-daily.xlsx');
    }
}
