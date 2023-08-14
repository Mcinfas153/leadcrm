<?php

namespace App\Exports;

use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class UserReportExport implements FromCollection, WithHeadings
{
    
    use Exportable;

    public $userId;
    public $period;

    public function forUser(int $userId)
    {
        $this->userId = $userId;
        
        return $this;
    }

    public function forPeriod(string $period)
    {
        $this->period = $period;
        
        return $this;
    }

    public function collection()
    {
        if($this->period == "daily"){

            $result = DB::table('user_activities')
                    ->join('actions', 'user_activities.action_id', '=' , 'actions.id')
                    ->select('user_activities.information','user_activities.created_at', 'actions.name as action_name')
                    ->where('user_activities.user_id', $this->userId)
                    ->whereDate('user_activities.created_at', timeZoneChange(config('custom.LOCAL_TIMEZONE')))
                    ->orderByDesc('user_activities.created_at')
                    ->get();

        } else if($this->period == "weekly"){

            $result = DB::table('user_activities')
                    ->join('actions', 'user_activities.action_id', '=' , 'actions.id')
                    ->select('user_activities.information','user_activities.created_at', 'actions.name as action_name')
                    ->where('user_activities.user_id', $this->userId)
                    ->whereBetween('user_activities.created_at', [timeZoneChange(config('custom.LOCAL_TIMEZONE'))->startOfWeek()->format('Y-m-d H:i:s'), timeZoneChange(config('custom.LOCAL_TIMEZONE'))->endOfWeek()->format('Y-m-d H:i:s')])
                    ->orderByDesc('user_activities.created_at')
                    ->get();            
        } else {

            $result = DB::table('user_activities')
                    ->join('actions', 'user_activities.action_id', '=' , 'actions.id')
                    ->select('user_activities.information','user_activities.created_at', 'actions.name as action_name')
                    ->where('user_activities.user_id', $this->userId)
                    ->whereBetween('user_activities.created_at', [timeZoneChange(config('custom.LOCAL_TIMEZONE'))->startOfMonth()->format('Y-m-d H:i:s'), timeZoneChange(config('custom.LOCAL_TIMEZONE'))->endOfMonth()->format('Y-m-d H:i:s')])
                    ->orderByDesc('user_activities.created_at')
                    ->get();

        }

        return $result;
    }

    public function headings(): array
    {
        return [
            'information',
            'created_at',
            'action_name',
        ];
    }
}
