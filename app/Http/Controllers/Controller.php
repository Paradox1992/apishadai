<?php

namespace App\Http\Controllers;



use App\Hooks\FilterChain;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, FilterChain;

    /**
     * Summary of sendError
     * @param mixed $error
     * @param mixed $errorMessages
     * @param mixed $code
     * @return mixed|\Illuminate\Http\JsonResponse
     */

    /**
     * Summary of sendResponse
     * @param mixed $result
     * @param mixed $message
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'data' => $result,
        ];
        return response()->json($response, $code);
    }
}