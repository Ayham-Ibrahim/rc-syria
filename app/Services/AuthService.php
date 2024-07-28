<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{

    public function register (array $data){
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken('authToken')->plainTextToken;

        // prepare message
        $data['email'] = $user->email;
        $data['body']  = "شكرا لكم لانضمامكم الينا وكونكم جزءاً من عائلتنا ";
        // send mail to user
        Mail::send('emails.notification', ['data' => $data], function ($message) use ($data) {
            $message->to($data['email'])->subject($data['body']);
        });

        return [
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token,
            'code' => 201,
        ];
    }


    public function login(array $credentials) {

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $credentials['email'])->firstOrFail();

        $token = $user->createToken('authToken')->plainTextToken;
        return [
            'status' => 'success',
            'message' => 'User loged in successfully',
            'user' => $user,
            'token' => $token,
            'code' => 200,
        ];
    }

}
