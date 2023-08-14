<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DailyUserReport extends Component
{

    public $userId;
    public $activityLimitPerPage = 10;
    public $period;

    protected $listeners = [
        'selectUser',
        'load-more-activities' => 'loadMore',
    ];

    public function mount()
    {
        $this->period = "daily";
        $this->userId = 0;
    }

    public function render()
    {
        if($this->period == "daily"){

            $activities = UserActivity::where('user_id', $this->userId)
                            ->whereDate('created_at', timeZoneChange(config('custom.LOCAL_TIMEZONE')))
                            ->orderByDesc('created_at')
                            ->paginate($this->activityLimitPerPage);

            $activityStats = DB::table('user_activities')
                            ->select('user_activities.*', 'actions.name as action_name')
                            ->selectRaw('count(*) as stat')
                            ->join('actions', 'user_activities.action_id', '=' , 'actions.id')
                            ->where('user_activities.user_id', $this->userId)
                            ->whereDate('user_activities.created_at', timeZoneChange(config('custom.LOCAL_TIMEZONE')))
                            ->orderByDesc('user_activities.created_at')
                            ->groupBy('user_activities.action_id')
                            ->get();

        } else if($this->period == "weekly"){

            $activities = UserActivity::where('user_id', $this->userId)
                            ->whereBetween('user_activities.created_at', [timeZoneChange(config('custom.LOCAL_TIMEZONE'))->startOfWeek()->format('Y-m-d H:i:s'), timeZoneChange(config('custom.LOCAL_TIMEZONE'))->endOfWeek()->format('Y-m-d H:i:s')])
                            ->orderByDesc('created_at')
                            ->paginate($this->activityLimitPerPage);

            $activityStats = DB::table('user_activities')
                            ->select('user_activities.*', 'actions.name as action_name')
                            ->selectRaw('count(*) as stat')
                            ->join('actions', 'user_activities.action_id', '=' , 'actions.id')
                            ->where('user_activities.user_id', $this->userId)
                            ->whereBetween('user_activities.created_at', [timeZoneChange(config('custom.LOCAL_TIMEZONE'))->startOfWeek()->format('Y-m-d H:i:s'), timeZoneChange(config('custom.LOCAL_TIMEZONE'))->endOfWeek()->format('Y-m-d H:i:s')])
                            ->orderByDesc('user_activities.created_at')
                            ->groupBy('user_activities.action_id')
                            ->get();

        } else {

            $activities = UserActivity::where('user_id', $this->userId)
                            ->whereBetween('user_activities.created_at', [timeZoneChange(config('custom.LOCAL_TIMEZONE'))->startOfMonth()->format('Y-m-d H:i:s'), timeZoneChange(config('custom.LOCAL_TIMEZONE'))->endOfMonth()->format('Y-m-d H:i:s')])
                            ->orderByDesc('created_at')
                            ->paginate($this->activityLimitPerPage);

            $activityStats = DB::table('user_activities')
                            ->select('user_activities.*', 'actions.name as action_name')
                            ->selectRaw('count(*) as stat')
                            ->join('actions', 'user_activities.action_id', '=' , 'actions.id')
                            ->where('user_activities.user_id', $this->userId)
                            ->whereBetween('user_activities.created_at', [timeZoneChange(config('custom.LOCAL_TIMEZONE'))->startOfMonth()->format('Y-m-d H:i:s'), timeZoneChange(config('custom.LOCAL_TIMEZONE'))->endOfMonth()->format('Y-m-d H:i:s')])
                            ->orderByDesc('user_activities.created_at')
                            ->groupBy('user_activities.action_id')
                            ->get();

        }

        return view('livewire.pages.daily-user-report',[
            'users' => User::where(['business_id' => Auth::user()->business_id, 'is_active' => 1])
                        ->get(),
            'activities' => $activities,
            'selectedUser' => User::find($this->userId),
            'activityStats' => $activityStats,
            'dataBox' => ['warning', 'success', 'danger', 'info', 'primary'],
            'dataBoxImg' => [
                'https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-briefcase.svg',
                'https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-user-male.svg',
                'https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-mailbox.svg',
                'https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-speech-bubble.svg',
                'https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-connect.svg'
            ]
        ])->layout('layouts.app',[
            'title' => 'user report'
        ]);
    }

    public function selectUser($userId)
    {
        $this->userId = $userId;
    }

    public function loadMore()
    {
        $this->activityLimitPerPage = $this->activityLimitPerPage + 5;
    }
}
