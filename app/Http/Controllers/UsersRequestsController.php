<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersRequestsController extends Controller
{
    public function passengersRequests()
    {
        // data
        $passengers = \App\Models\Passenger::where(['confirmed' => 0])->get()->all();

        // get unconfirmed passengers
        return view('pages.requests.passenger', [
            'data' => $passengers
        ]);
    }

    public function driverRequests()
    {
        $driver = \App\Models\Driver::where(['confirmed' => 0])->get()->all();

        return view('pages.requests.driver', [
            'data' => $driver
        ]);
    }

    public function carRequests()
    {
        $car = \App\Models\Car::where(['confirmed' => 0])->get()->all();

        return view('pages.requests.car', [
            'data' => $car
        ]);
    }

    public function acceptPassengersRequests(Request $request)
    {
        $passenger = \App\Models\Passenger::findOrFail($request['id']);
        try {
            $passenger->confirmed = 1;
            $passenger->save();

            return back()->with('success', "تم قبول الراكب $passenger->name");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function acceptDriverRequests(Request $request)
    {
        $driver = \App\Models\Driver::findOrFail($request['id']);
        try {
            $driver->confirmed = 1;
            $driver->save();

            return back()->with('success', "تم قبول السائق $driver->name");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function acceptCarRequests(Request $request)
    {
        $car = \App\Models\Car::findOrFail($request['id']);
        try {
            $car->confirmed = 1;
            $car->save();

            return back()->with('success', "تم قبول السيارة");
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
