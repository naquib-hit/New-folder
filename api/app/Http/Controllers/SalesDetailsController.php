<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use App\Models\{ SalesDetails, Car };
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class SalesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $collection = collect(SalesDetails::leftJoin('cars', 'cars.id', '=', 'sales_details.car')->cursor());
        $sales = $collection;    

        return response()->json($sales, 200);
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
        $name   = $request->input('customer_name');
        $email  = $request->input('customer_email');
        $phone  = $request->input('customer_phone');
        $car    = $request->input('car_id');

        // validasi
        $validator = Validator::make($request->all(), [
            'customer_name'     => 'required',
            'customer_email'    => 'required|email',
            'customer_phone'    => [
                                        'required',
                                        'regex:/^(\+62|62)?[\s-]?0?8[1-9]{1}\d{1}[\s-]?\d{4}[\s-]?\d{2,5}$/' // -> regex for phone e.g. (+62) XXX XXXX XXXX, XXXX XXXX XX
                                    ]
        ]);

        if($validator->fails()) {
            $ret = ['success' => false, 'message' => 'Data input tidak valid !!!'];
            return response()->json($ret, 422);
        }

        $create = SalesDetails::create([
            'customer_name'     => $name,
            'customer_email'    => $email,
            'customer_phone'    => $phone,
            'car'               => $car,
            'sale_date'         => (new \DateTime)->format('Y-m-d H:i:s')
        ]);

        if(empty($create['customer_name'])) {
            $ret = ['success' => false, 'message' => 'Data gagal di simpan !!!'];
            return response()->json($ret, 422);
        }

        // Get data for depency injection to InvoicePaid. must return SalesDetails
        $customer = SalesDetails::where('sales_details.id', $create->id)
                            ->join('cars', 'cars.id', '=', 'sales_details.car')
                            ->first();

        // send mail
        Notification::route('mail', 'naquibalatas1987@outlook.com')
            ->notify(new InvoicePaid($customer));

        $ret = ['success' => true, 'message' => 'Transaksi berhasil !!!'];
        return response()->json($ret, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Buat email notifikasi
        $customer = SalesDetails::firstOrFail('id', $id)->join('cars', 'sales_details.cars', '=', 'cars.id');

        $params = [
            'name'      => $customer->customer_name,
            'email'     => $customer->customer_email,
            'phone'     => $customer->customer_phone,
            'car_name'  => $customer->car_name,
            'car_price' => number_format($customer->car_price, 2)
        ];

        return view('mail.invoice', $params)->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesDetails $salesDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesDetails $salesDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesDetails $salesDetails)
    {
        //
    }

    /**
     * summary.
     *
     * @return \Illuminate\Http\Response
     */
    public function summary()
    {
        // 1. group array by date
        $coll = collect(SalesDetails::getSumm())
                                            ->mapToGroups(function($item) {
                                                    $data = [];
                                                    $data[$item['sale_date']] = [
                                                        'date' => $item['sale_date'],
                                                        'car'  => $item['car_name'],
                                                        'sold' => $item['total_sold'],
                                                        'sum'  => $item['total_sum'],
                                                    ];
                                                    return $data;
                                        })->all();
        // 2. need to iterate to deep of array 
       $enp = [];

       foreach($coll as $k => $v) 
       {
           //check if key has backdate
           $dateBefore = (new \DateTime($k))->modify('-1 day')->format('Y-m-d');
           foreach($v as $key => $val)
           {
               $newArr = [];
               //check if items is exists
                if(!empty($coll[$dateBefore][$key]['sum']) && isset($coll[$dateBefore]))
                    $newArr['diff'] = ($val['sum'] * 100) / $coll[$dateBefore][$key]['sum'];
                else
                    $newArr['diff'] = NULL;
                
                // declare 
                $newArr['date']     = $val['date'];
                $newArr['car']      = $val['car'];
                $newArr['sold']    = $val['sold'];
                $newArr['sum']      = $val['sum'];

                $enp[] = $newArr;
           }
       }
		
		unset($coll);
        return response()->json($enp, 200);   
    }

    
}
