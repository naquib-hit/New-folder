<?php

namespace App\Http\Controllers\API;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get cars
        
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
        

        // validate
        $validator = Validator::make($request->all(), [
            'car_name'  => 'required|unique:cars,car_name', // car_name unique
            'car_price' => 'required',
            'stock'     => 'required' 
        ]);
        // if invalid
        if($validator->fails())
        {
            $ret = ['success' => false, 'message' => 'Data gagal di simpan'];
            return response()->json($ret, 422);
        }

        $name  = $request->car_name;
        $price = $request->car_price;
        $stock = $request->stock;

        $create = Car::create([
            'car_name'  => $name,
            'car_price' => $price,
            'stock'     => $stock
        ]);

        // if insert is failed
        if(!$create)
        {
            $ret = ['success' => false, 'message' => 'Data gagal di simpan !!!'];
            return response()->json($ret, 422);
        }

        return response()->json(['success' => true, 'message' => 'Data berhasil di simpan'], 200);
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
