<?php

namespace App\Http\Traits;

use App\Models\LeadActivity;
use App\Models\UserActivity;
use Illuminate\Support\Facades\DB;

trait ActivityTrait{

    public static function add(int $userId, int $actionId, string $infomation = "", int|null $leadId = null): void
    {

        //dd($userId);
        DB::beginTransaction();

        try {
            
            if(isset($leadId)){

                LeadActivity::create([
                    'lead_id' => $leadId,
                    'user_id' => $userId,
                    'action_id' => $actionId,
                    'information' => $infomation
                ]);
            }
    
            UserActivity::create([
                'user_id' => $userId,
                'action_id' => $actionId,
                'information' => $infomation
            ]);

            DB::commit();

          } catch (\Exception $e) {

            DB::rollBack();
            
            dd($e->getMessage());
        }
    }

}