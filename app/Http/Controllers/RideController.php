<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Models\Ride;
use App\Http\Requests\StoreRideRequest;
use App\Http\Requests\UpdateRideRequest;
use Illuminate\Support\Facades\DB;

class RideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ride_arr = [];

        $rides = collect(\App\Models\Ride::all())->each(function ($ride) use (&$ride_arr) {
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

        return view('pages.rides.index', ['data' => $ride_arr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $driver_id = \App\Models\Driver::where('email', auth()->user()->email)->get()->all()[0]->id;
        $cars = \App\Models\Car::where(['driver_id' => $driver_id, 'confirmed' => 1])->get()->all();

        return view('pages.rides.addRide', [
            'data' => [
                'driver_id' => $driver_id,
                'cars' => $cars
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRideRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRideRequest $request)
    {
        // init Ride Model
        $Ride = new \App\Models\Ride();

        // get form request
        $validate = $request->validated();

        // filter validated request
        $filter_request = array_filter($validate, function ($item) {
            return $item != null || $item != '';
        });

        foreach ($filter_request as $key => $value) {
            $Ride->$key = $value;
        }

        try {
            $car = \App\Models\Car::find($Ride->car_id);
            $Ride->actual_reservation_nums = $car->seats_num;
            $Ride->save();
            return back()->with('success', 'تم إنشاء الرحلة بنجاح');
        } catch (\Exception $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function show(Ride $ride)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function edit(Ride $ride)
    {
        $driver_id = \App\Models\Driver::where('email', auth()->user()->email)->get()->all()[0]->id;
        $cars = \App\Models\Car::where(['driver_id' => $driver_id, 'confirmed' => 1])->get()->all();
        return view('pages.rides.update', [
            'ride' => $ride,
            'data' => [
                'cars' => $cars,
                'driver_id' => $driver_id
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRideRequest  $request
     * @param  \App\Models\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRideRequest $request, Ride $ride)
    {
        $validate = $request->validated();
        // filter inputs
        $filter_request = array_filter($validate, function ($value) {
            return $value != null || $value != '';
        });

        foreach ($filter_request as $key => $value) {
            $ride->$key = $value;
            if ($key == 'once_date') {
                $ride->multi_date = null;
            }
            if ($key == 'multi_date') {
                $ride->once_date = null;
            }
        }

        DB::beginTransaction();
        try {
            $ride->save();
            ManualEvent::notificationEvent([
                'user_id' => auth()->user()->id,
                'message' => "تم تعديل الرحلة رقم $ride->id الوجهة $ride->from --> $ride->to",
                'alert_type' => 'update',
                'af_model' => 'Ride',
                'af_model_id' => $ride->id
            ]);

            DB::commit();
            return back()->with('success', 'تم التحديث بنجاح');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ride  $ride
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ride $ride)
    {
        try {
            $ride->delete();
            ManualEvent::notificationEvent([
                'user_id' => auth()->user()->id,
                'message' => "تم حذف الرحلة رقم $ride->id الوجهة $ride->from --> $ride->to",
                'alert_type' => 'delete',
                'af_model' => 'Ride',
                'af_model_id' => $ride->id
            ]);
            return redirect()->route('report.my_rides');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
