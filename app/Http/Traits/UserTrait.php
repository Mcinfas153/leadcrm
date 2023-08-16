<?php

namespace App\Http\Traits;

use App\Models\User;
use Carbon\Carbon;

trait UserTrait{

    public static function bestPerformer(int $organizationId):array|object
    {
        $result = User::has('activities')
                    ->where(['is_active' => 1, 'business_id' => $organizationId, 'user_type' => config('custom.USER_NORMAL')])
                    ->whereBetween('created_at',[Carbon::now()->subHour(6), Carbon::now()])
                    ->get();

        return $result;
    } 

}