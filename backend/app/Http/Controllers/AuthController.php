<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails())
            return response(['errors'=>$validator->errors()->all()], 422);

        $user = User::where("username", $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('BSIT2023' . $user->username)->plainTextToken;
                $response = ['token' => $token];
                return response()->json($response, 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response()->json($response, 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response()->json($response, 422);
        }
    }

    public function profile(Request $request){
        $response = $request->user();
        return response()->json($response, 200);
    }
}
