<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(request $request){

        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);



        if($validator->fails()){
            return error_response($validator->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->save();
        $data = $user->only('name','email');

        return success_response($data,'User Added Successfully',201);



    }

    public function index(){
        $users = User::select('id','name','email')->orderby('id', 'DESC')->get();
        //$users = User::all('name','email');
        return success_response($users,'',200);
    }


}
