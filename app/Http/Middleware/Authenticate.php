<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    //handles unauthenticated users
    protected function unauthenticated($request, array $guards)
    {
        abort(401);
    }

}