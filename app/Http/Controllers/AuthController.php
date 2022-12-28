<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //membuat fungsi login
    function login(Request $request){
        //get user detail
        $user = User::query()
        ->where("email", $request->input("email"))
        ->first();

        //check user ada ga
        if($user == null){
            return response()->json([
                "status" => false,
                "message" => "email tidak ditemukan",
                "data" => null
            ]);
        }

        //check passwordnya
        if(!Hash::check($request->input("password"), $user->password)){
            return response()->json([
                "status" => false,
                "message" => "password salah",
                "data" => null
            ]);
        }

        //create user token
        //biar bisa masuk ke aplikasi
        //buat authorizationnya
        $token = $user->createToken("auth_token");


        return response()->json([
            "status" => true,
            "message" => "",
            "data" => [
                "auth" => [
                    "token" => $token->plainTextToken,
                    "token_type" => 'Bearer'
                ],
                "user" => $user
            ]
        ]);

    }

    //mengambil user berdasarkan token yang diberikan
    function getUser(Request $request){
        $user = $request->user();
        return response()->json([
            "status" => true,
            "message" => "",
            "data" => $user
        ]);
    }
}
