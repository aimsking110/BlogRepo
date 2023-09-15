<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{   
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            
            
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'fails',
                'message' => "Validation Error" ,
                'errors' => $validator->errors()
        ],404);
        }
        $user =User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
    
        ]);
        $user->sendEmailVerificationNotification();


        return response()->json([
            'status' => true,
            'message' => 'Success',
            'token' => $user->createToken("API TOEKN")->plainTextToken,
            'data' => $user
        ]);
        
     }

     public function login(Request $request)
     {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Check if the user is approved
            $user = Auth::user();
            if (!$user->approved) {
                return response()->json(['message' => 'Account not approved.'], 401);
            }
            return response()->json(['message' => 'Login Successfully',  'token' => $user->createToken("APT TOEKN")->plainTextToken,], 200);
        }
        return response()->json(['message' => 'Invalid credentials.'], 401);
      
      }
}
