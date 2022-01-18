<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverPublicController extends Controller
{
    public function driverSchedule(Request $request)
    {
        return view('includes.tables.driver.ridesSchedule');
    }

    public function myCars(Request $request)
    {
        $driver_id = DB::table('drivers')->where('email', auth()->user()->email)->get()->all()[0]->id;

        return view('pages.driver.myCars', [
            'data' => collect(\App\Models\Car::where(['driver_id' => $driver_id])->get()->values())->toArray()
        ]);
    }
    public function myRidesReport(Request $request)
    {
        $driver_id = DB::table('drivers')->where('email', auth()->user()->email)->get()->all()[0]->id;

        $ride_arr = [];

        $rides = collect(\App\Models\Ride::where(['driver_id' => $driver_id])->get()->values())->each(function ($ride) use (&$ride_arr) {
            if ($ride['occurance'] == 'custome') {
                $arr = json_encode(explode(', ', $ride['multi_date']));
                $arr_decode = json_decode($arr);

                foreach ($arr_decode as $key => $value) {
                    array_push($ride_arr, [
                        'id' => $ride['id'],
                        'driver_id' => $ride['driver_id'],
                        'car_id' => $ride['car_id'],
                        'driver' => $ride['driver'],
                        'car' => $ride['car'],
                        'from' => $ride['from'],
                        'to' => $ride['to'],
                        'actual_reservation_nums' => $ride['actual_reservation_nums'],
                        'time' => $ride['time'],
                        'amount' => $ride['amount'],
                        'occurance' => $ride['occurance'],
                        'once_date' => $ride['once_date'],
                        'multi_date' => $value,
                        'waitting' => $ride['waitting'],
                        'status' => $ride['status'],
                        'created_at' => $ride['created_at'],
                        'updated_at' => $ride['updated_at'],
                    ]);
                }
                return $ride;
            } else {
                array_push($ride_arr, [
                    'id' => $ride['id'],
                    'driver_id' => $ride['driver_id'],
                    'car_id' => $ride['car_id'],
                    'driver' => $ride['driver'],
                    'car' => $ride['car'],
                    'from' => $ride['from'],
                    'to' => $ride['to'],
                    'actual_reservation_nums' => $ride['actual_reservation_nums'],
                    'time' => $ride['time'],
                    'amount' => $ride['amount'],
                    'occurance' => $ride['occurance'],
                    'once_date' => $ride['once_date'],
                    'multi_date' => $ride['multi_date'],
                    'waitting' => $ride['waitting'],
                    'status' => $ride['status'],
                    'created_at' => $ride['created_at'],
                    'updated_at' => $ride['updated_at'],
                ]);
                return $ride;
            }
        });

        return view('reports.driver.rides', [
            'data' => $ride_arr
        ]);
    }
}
