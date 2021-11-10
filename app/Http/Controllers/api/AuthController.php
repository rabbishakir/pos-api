<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function listUsers(Request $request){
        return $request;
    }
}
