<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;


class AuthController extends BaseController
{

    public function signin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => bcrypt($request->password)])){ 
            $authUser = Auth::user(); 
            $success['token'] =  $authUser->createToken('oufairekoi@pp')->plainTextToken; 
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, 'Utilisateur connecté');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);
        } 
    }


    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            // 'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }

        $input = $request->all();

        $checkEmail = User::where('email', $input['email'])->first();
        
        if(!$checkEmail) {
            $user = User::create($input);
            $input['password'] = bcrypt($input['password']);
            $success['token'] =  $user->createToken('oufairekoi@pp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'Utilisateur crée avec succès !');
        }

        return $this->sendError('Cet utilisateur existe déjà');
        
    }
}
