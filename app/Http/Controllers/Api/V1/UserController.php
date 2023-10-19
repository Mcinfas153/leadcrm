<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\PushNotificationBrowser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createPushNotificationBrowser(Request $request)
    {
        $message = "";
        $code = 0;

        if (!$request->hasHeader('userId')) {
            $message = "user id missing";
            $code = 400;

            return ApiResponse::sendResponse($message, $code, [] );
        }

        try {

            $browser = new PushNotificationBrowser();
            $browser->data = $request->getContent();
            $browser->user_id = $request->header('userId');
            $browser->save();

            $message = 'success';
            $code = 201;

            return ApiResponse::sendResponse($message, $code, $browser );

        } catch(\Exception $e) {
           
            return ApiResponse::sendResponse($e->getMessage(), 500, [] );
        }
    }
}
