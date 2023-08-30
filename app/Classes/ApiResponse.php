<?php

namespace App\Classes;

use App\Http\Controllers\Controller;

class ApiResponse extends Controller{

    public static function sendResponse($message = "", int $statusCode = 200, array|object $data = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
            'data' => $data
        ]);
    }

}