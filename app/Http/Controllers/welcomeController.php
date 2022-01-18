<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class welcomeController extends Controller
{
    public function welcome()
    {
        // reservation
        $reserves_status = new \App\Models\StatusReserve();
        $ride = new \App\Models\Ride();

        switch (auth()->user()->user_role) {
            case 'passenger':
                $now = \Carbon\Carbon::now();
                $ride_arr = [];
                $pass_id = DB::table('passengers')->where('email', auth()->user()->email)->get()->all()[0]->id;
                $data = $pass_id ? collect($reserves_status::wherePassengerId($pass_id)->get()->values())->each(function ($reserves_status) use (&$ride_arr) {
                    if ($reserves_status['reserve']['occurance'] == 'custome') {
                        $arr = json_encode(explode(', ', $reserves_status['reserve']['multi_dates']));
                        $arr_decode = json_decode($arr);

                        foreach ($arr_decode as $key => $value) {
                            array_push($ride_arr, [
                                'id' => $reserves_status['id'],
                                'passenger_id' => $reserves_status['passenger_id'],
                                'ride_id' => $reserves_status['ride_id'],
                                'reserve_id' => $reserves_status['reserve_id'],
                                'total_amount' => $reserves_status['total_amount'],

                                'ride' => $reserves_status['ride'],
                                'passenger' => $reserves_status['passenger'],
                                'reserve' => $reserves_status['reserve'],

                                'multi_date' => $value,

                                'created_at' => $reserves_status['created_at'],
                                'updated_at' => $reserves_status['updated_at'],
                            ]);
                        }
                        return $reserves_status;
                    } else {
                        array_push($ride_arr, [
                            'id' => $reserves_status['id'],
                            'passenger_id' => $reserves_status['passenger_id'],
                            'ride_id' => $reserves_status['ride_id'],
                            'reserve_id' => $reserves_status['reserve_id'],
                            'total_amount' => $reserves_status['total_amount'],

                            'ride' => $reserves_status['ride'],
                            'passenger' => $reserves_status['passenger'],
                            'reserve' => $reserves_status['reserve'],

                            'multi_date' => null,

                            'created_at' => $reserves_status['created_at'],
                            'updated_at' => $reserves_status['updated_at'],
                        ]);
                        return $reserves_status;
                    }
                }) : [];

                // dd($ride_arr);

                return view('welcome', [
                    'data' => [
                        'reserves_status' => collect($ride_arr)->where('multi_date', '>=', $now)->all()
                    ]
                ]);
                break;
            case 'driver':
                $driver_id = DB::table('drivers')->where('email', auth()->user()->email)->get()->all()[0]->id;
                $result = collect($ride::whereDriverId($driver_id)->get()->values())->map(function ($value, $key) {

                    $value['actual_reservation_nums'] = ($value['car']['seats_num'] - $value['actual_reservation_nums']);

                    return $value;
                })->toArray();

                return view('welcome', [
                    'data' => [
                        'reserves' => $driver_id ? $result : []
                    ]
                ]);
                break;
            case 'admin':
                return view('welcome', [
                    'cars_count' => \App\Models\Car::where('confirmed', 0)->count(),
                    'drivers_count' => \App\Models\Driver::where('confirmed', 0)->count(),
                    'passengers_count' => \App\Models\Passenger::where('confirmed', 0)->count(),
                ]);
        }
    }
}
