<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;


class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(request $request){

        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        try{

            if($validator->fails()){
                return error_response($validator->errors());
            }

            $user = new User();
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->email = $request->email;
            $user->save();
            $data = $user->only('name','email');

            return success_response($data,__('custommsg.user.create.success'),201);

        }catch(Exception $exception){
            return error_response($exception);
        }

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){

        $users = User::select('id','name','email')->orderby('id', 'DESC')->get();
        //$users = User::all('name','email');
        return success_response($users,__('custommsg.user.manage.error'),200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        $user= User::find($id);
        if($user){
            return success_response($user,'',200);
        }else{
            return error_response(__('custommsg.user.manage.not_found'));
        }

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $user= User::find($id);
        if($user){
            $user->delete();
            return success_response($user,__('custommsg.user.manage.deleted'),200);
        }else{
            return error_response(__('custommsg.user.manage.not_found'));
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */

    public function edit(Request $request, $id)
    {
        $user= User::find($id);
        if($user){
            $validator = Validator::make($request->all(),[
                'name'=> 'required',
                'email' => 'required|email|unique:users,email',
            ]);

            if($validator->fails()){
                return error_response($validator->errors());
            }else{

               /// return 123;
               $user->name = $request->name;
               $user->email = $request->email;
               $user->save();
               return success_response($user,__('custommsg.user.update.success'),200);
            }

        }

    }


}
