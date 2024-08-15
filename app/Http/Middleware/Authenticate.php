<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        //return $request->expectsJson() ? null : route('login');
        http_response_code(401);
        die(' No token provided');


    }
    private function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'data' => $result,
        ];
        return $response;
        // return response()->json($response, $code);
    }
}