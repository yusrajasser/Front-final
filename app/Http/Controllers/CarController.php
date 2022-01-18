<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ddd(\App\Models\Car::with('driver')->get()->all());
        return view('pages.car.index', ['data' => \App\Models\Car::with('driver')->get()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = new User();
        // $drivers = collect(Driver::all());

        $drivers = DB::table('drivers')->join('users', 'drivers.email', '=', 'users.email')->select('drivers.*', 'users.access_key')->get();

        return view('pages.car.add', [
            'data' => json_decode(json_encode($drivers), true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarRequest $request)
    {
        $car = new Car();
        $validate = $request->validated();

        $filter = array_filter($validate, function ($value) {
            return $value != null;
        });

        foreach ($filter as $key => $value) {
            $car->$key = $value;
            if ($key == 'car_license') {
                $car->car_license = Str::substr($request->file('car_license')->store('public/CarsLicenses'), 6);
            }
        }

        try {
            $car->save();

            return back()->with('success', 'تم إنشاء السيارة بنجاح');
        } catch (\Throwable $th) {

            return back()->with('error', $th->getMessage());
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return view('pages.show.car', [
            'car' => $car
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        // $drivers = Driver::all();
        $drivers = DB::table('drivers')->join('users', 'drivers.email', '=', 'users.email')->select('users.*', 'users.access_key')->get();

        if (auth()->user()->user_role == 'admin') {
            return view('pages.car.update', [
                'data' => json_decode(json_encode($drivers), true),
                'car' => $car
            ]);
        }
        if (auth()->user()->user_role == 'driver') {
            return view('pages.driver.updateCar', [
                'data' => json_decode(json_encode($drivers), true),
                'car' => $car
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarRequest  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        // $ride = \App\Models\Ride::whereCarId($car->id)->get()->all()[0];

        $validate = $request->validated();
        // filter inputs
        $filter_request = array_filter($validate, function ($value) {
            return $value != null || $value != '';
        });

        foreach ($filter_request as $key => $value) {
            $car->$key = $value;
            if ($key == 'car_license') {
                $car->car_license = Str::substr($request->file('car_license')->store('public/CarsLicenses'), 6);
            }
        }

        try {
            $car->save();
            ManualEvent::notificationEvent([
                'user_id' => auth()->user()->id,
                'message' => "تم تعديل السيارة رقم $car->id",
                'alert_type' => 'update',
                'af_model' => 'Ride',
                'af_model_id' => $car->id
            ]);

            return back()->with('success', 'تم التحديث بنجاح');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        try {
            $car->delete();
            ManualEvent::notificationEvent([
                'user_id' => auth()->user()->id,
                'message' => "تم حذف السيارة رقم $car->id",
                'alert_type' => 'delete',
                'af_model' => 'Car',
                'af_model_id' => $car->id
            ]);
            return back()->with('success', 'تم بنجاح');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
