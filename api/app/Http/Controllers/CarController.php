<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator as Validator;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getCars
        $cars = collect(Car::cursor())->all();

        return response()->json($cars, 200);
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
        $name = $request->input('car_name');
        $price = $request->input('car_price');
        $stock = $request->input('car_stock');

        $validator = Validator::make($request->all(), [
            'car_name'  => 'required|unique:cars,car_name',
            'car_price' => 'required|numeric',
            'car_stock' => 'required|numeric'
        ]);

        if($validator->fails()) {
            $ret = ['success' => false, 'message' => 'Data form tidak valid !!!'];
            return response()->json($ret, 422);
        }

        $create = Car::create([
            'car_name' => $name,
            'car_price' => $price,
            'stock' => $stock
        ]);

        if(!$create) {
            $ret = ['success' => false, 'message' => 'Data gagal di simpan !!!'];
            return response()->json($ret, 422);
        }

        $ret = ['success' => true, 'message' => 'Data berhasil di simpan !!!'];
        return response()->json($ret, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        //
         //
         $name = $request->input('car_name');
         $price = $request->input('car_price');
         $stock = $request->input('car_stock');
         $id = $request->input('car_id');
 
         $validator = Validator::make($request->all(), [
             'car_name'  => 'required',
             'car_price' => 'required|numeric',
             'car_stock' => 'required|numeric',
             'car_id'    => 'required|numeric'
         ]);
 
         if($validator->fails()) {
             $ret = ['success' => false, 'message' => 'Data form tidak valid !!!'];
             return response()->json($ret, 422);
         }
         
         $car = Car::find($id)->update([
            'car_name'  => $name,
            'car_price' => $price,
            'stock' => $stock
         ]);
 
         if(!$car) {
             $ret = ['success' => false, 'message' => 'Data gagal di simpan !!!'];
             return response()->json($ret, 422);
         }
 
         $ret = ['success' => true, 'message' => 'Data berhasil di simpan !!!'];
         return response()->json($ret, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $d
     * @return \Illuminate\Http\Response
     */
    public function destroy($d)
    {
        //
        $car = Car::findOrFail($d);
        $car->delete();

        $ret = ['success' => true, 'message' => 'Data berhasil di hapus !!!'];
        return response()->json($ret, 200);
    }
}
