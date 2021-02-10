<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name'    => $request->input('first_name'), 
            'last_name'     => $request->input('last_name'), 
            'email'         => $request->input('email'), 
            'phone_number'  => $request->input('phone_number'),
            'password'      => Hash::make($request->input('password'))
        ]);

        return response()->json($user);
    }

    public function login(LoginRequest $request) 
    {        
        if( Auth::attempt(['phone_number'=>$request->phone_number, 'password'=>$request->password]) ) {
            $user = Auth::user();
            $token = $user->createToken($user->email.'-'.now());
            return response()->json([
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
            ]);
        }
        return response()->json(['error' => 'Invalid Credentials']);
    }
}
