<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    /**
     * login function
     * 
     * @return json
     */
    public function login(Request $req) {

        $username = $req->input('username');
        $password = $req->input('password');

        $validator = Validator::make($req->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        // cek default validation
        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // cek otentikasi
        if(!Auth::attemp(['username' => $username, 'password' => $password])) {
            $ret = ['success' => false, 'message' => 'Proses login gagal'];
            return response()->json($ret, 422);
        }

        return response()->json(['success' => true, 'token' => $token], 200);

    }

}
