<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Models\Passenger;
use App\Http\Requests\StorePassengerRequest;
use App\Http\Requests\UpdatePassengerRequest;
use Exception;
use Illuminate\Support\Facades\DB;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passengers = DB::table('passengers')->join('users', 'passengers.email', '=', 'users.email')->select('passengers.*', 'users.access_key')->get();

        return view('pages.passenger.index', [
            'data' => json_decode(json_encode($passengers), true)
        ]);
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
     * @param  \App\Http\Requests\StorePassengerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePassengerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function show(Passenger $passenger)
    {
        return view('pages.show.passenger', [
            'passenger' => $passenger
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function edit(Passenger $passenger)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePassengerRequest  $request
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePassengerRequest $request, Passenger $passenger)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Passenger  $passenger
     * @return \Illuminate\Http\Response
     */
    public function destroy(Passenger $passenger)
    {
        $models = ['reserves', 'status_reserves', 'messages'];

        try {

            foreach ($models as $model) {
                DB::table($model)->where('passenger_id', $passenger->id)->delete();
            }

            ManualEvent::DeleteUser($passenger->email);
            $passenger->delete();

            return back();
        } catch (Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
