<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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
            return response()->json($validator->errors());
        }
        // cek otentikasi
        if(!Auth::attemp(['username' => $username, 'password' => $password])) {
            
        }
    }
}
