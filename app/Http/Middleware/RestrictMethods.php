<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RestrictMethods
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE'];
            if (!in_array($request->method(), $allowedMethods)) {
                return $this->sendResponse(null, 'Not Supported Yet', 405);
            }
            return $next($request);
        } catch (Throwable $th) {
            return $this->sendResponse(null, $th->getMessage(), 500);
        }
    }

    private function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'data' => $result,
        ];
        return response()->json($response, $code);
    }
}