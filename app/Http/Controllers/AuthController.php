<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Webpatser\Uuid\Uuid;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $registration = DB::transaction(function () use($request) {
            $user = User::create([
                'first_name'    => $request->input('first_name'), 
                'last_name'     => $request->input('last_name'), 
                'email'         => $request->input('email'), 
                'phone_number'  => (string) PhoneNumber::make($request->input('phone_number'), 'UG')->formatE164(),
                'password'      => Hash::make($request->input('password'))
            ]);
            
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'wallet_no' => Uuid::generate(),
                'account_balance' => 0
            ]);
            return compact('user', 'wallet');
        });
        return response()->json($registration['user']);
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
