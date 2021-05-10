<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function register(Request $request, Response $response){
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => \bcrypt($fields['password'])
        ]);

        $token = $user->createToken('my_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }

    public function login(Request $request, Response $response){
        $fields = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // check email
        $user = User::where('email', $fields['email'])->first();
        // check password

        if(!$user || !Hash::check($fields['password'], $user->password)){

            return response([
                'message' => 'Bad credentials'
            ], 401);
        }
        $token = $user->createToken('my_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

}
