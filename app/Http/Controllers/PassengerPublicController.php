<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PassengerPublicController extends Controller
{
    public function passengerSchedule(Request $request)
    {
        // // reservation
        // $reserves_status = new \App\Models\StatusReserve();

        // // bring passenger id fro his table
        // $pass_id = DB::table('passengers')->where('email', auth()->user()->email)->get()->all()[0]->id;

        // return view('welcome', [
        //     'data' => [
        //         'reserves_status' => $reserves_status::wherePassengerId($pass_id)->get()->all()[0]
        //     ]
        // ]);
    }
    public function myReservesReport(Request $request)
    {
        $reserves_status = new \App\Models\StatusReserve();
        $pass_id = DB::table('passengers')->where('email', auth()->user()->email)->get()->all()[0]->id;
        return view('reports.passenger.reserves', [
            'data' => [
                'reserves_status' => $pass_id ? collect($reserves_status::wherePassengerId($pass_id)->get()->values())->toArray() : []
            ]
        ]);
    }
}
