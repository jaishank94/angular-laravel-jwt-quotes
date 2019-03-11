<?php

namespace App\Http\Controllers;

use App\Quote;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Execption\JWTException;
use JWTAuth;

class UserController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User();
        $user->name = trim($request['name']);
        $user->email = trim($request['email']);
        $user->password = bcrypt(trim($request['password']));
        $user->save();

        return response()->json(['message' => 'Successfully Registered'], 201);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $creds = $request->only('email','password');
        try{
            if(!$token = JWTAuth::attempt($creds)){
                return response()->json(['error' => 'Invalid Cred.'], 401);
            }
        } catch(JWTException $e) {
            return response()->json(['error' => 'Unable to create token'], 500);
        }

        return response()->json(['token' => $token], 200);
    }
}
