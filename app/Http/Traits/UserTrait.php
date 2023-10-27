<?php

namespace App\Http\Traits;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

trait UserTrait{

    public static function bestPerformer(int $organizationId):array|object
    {

        $result = User::whereHas('activities', function (Builder $query) {
            $query->whereBetween('created_at',[localTimeConvert(config('custom.LOCAL_TIMEZONE'), Carbon::now()->subHour(6)), localTimeConvert(config('custom.LOCAL_TIMEZONE'), Carbon::now())]);
                    
        })
        ->where(['is_active' => 1, 'business_id' => $organizationId, 'user_type' => config('custom.USER_NORMAL')])
        ->get();

        return $result;
    } 

}