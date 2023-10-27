<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\ApiResponse;
use App\Http\Resources\LeadResource;
use App\Mail\NewLead;
use App\Models\Lead;
use App\Models\PushNotificationBrowser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Traits\NotificationTrait;

class LeadController extends Controller
{
    public function create(Request $request)
    {
        if ($request->hasHeader('Authorization')) {

            $authCode = $request->header('Authorization');
            $business = Organization::where('auth_code', $authCode)->first();

            if(empty($business)){

                return ApiResponse::sendResponse('business not found');

            }

            if($business->is_active == 0){

                return ApiResponse::sendResponse('business not active');
            }

            $inputs = $request->all();

            $validator = Validator::make($inputs, [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'campaign_name' => 'required',
            ]);
     
            if ($validator->fails()) {
                return ApiResponse::sendResponse($validator->errors());
            }

            DB::beginTransaction();

            try {

                $lead = Lead::create($inputs);
                $lead->created_by = $business->created_by;
                $lead->assign_to = $business->created_by;
                $lead->assign_time = timeZoneChange(config('custom.LOCAL_TIMEZONE'));
                $lead->save();

                DB::commit();

                $insertedLead = Lead::find($lead->id);

                //notify new lead email
                if(config('custom.IS_MAIL_ON')){

                    $allBrowsers = PushNotificationBrowser::where('user_id', $lead->created_by)->get();

                    foreach($allBrowsers as $browser){
                        
                        NotificationTrait::push($browser->id, config('message.NEW_LEAD_RECIEVED'), env('APP_URL').'lead/view/'.$insertedLead);
                    
                    }

                        Mail::to(User::find($lead->created_by)->email)->queue(new NewLead($insertedLead));              
                }

                return ApiResponse::sendResponse('lead created successfully', 201, new LeadResource($insertedLead));

            } catch(\Exception $e) {

                DB::rollBack();

                return ApiResponse::sendResponse(Str::limit($e->getMessage(), 100), 500);
            }
            
        }
    }
}
