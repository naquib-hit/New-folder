<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\{ Auth, Validator};

class UserController extends Controller
{
    /**
     * Auth Login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        $name = $request->input('username');
        $pass = $request->input('password');

        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required']
        ]);

        // if fails
        if($validator->fails())
        {
            $ret = ['success' => false, 'message' => 'Username atau Password Salah !!!'];
            return response()->json($ret, 422);
        }
        // cek jika user ada

        if(!Auth::attempt(['username' => $name, 'password' => $pass]))
        {
            $ret = ['success' => false, 'message' => 'Identifikasi Gagal !!!'];
            return response()->json($ret, 401);
        }

        $token = Auth::user()->createToken(Auth::user())->plainTextToken;
        return response()->json(['success' => true, 'message' => 'Login Berhasil !!!', 'access_token' => $token], 200);
    }

     /**
     * GET USer.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request) {
        return auth()->user()->username;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
