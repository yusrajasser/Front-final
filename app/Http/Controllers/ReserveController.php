<?php

namespace App\Http\Controllers;

use App\Helper\ManualEvent;
use App\Models\Reserve;
use App\Http\Requests\StoreReserveRequest;
use App\Http\Requests\UpdateReserveRequest;
use Illuminate\Support\Facades\DB;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reserves_status = new \App\Models\StatusReserve();
        return view(
            'pages.reserve.index',
            [
                'data' => [
                    'reserves_status' => collect($reserves_status::all())
                ]
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // init ride
        $rides = new \App\Models\Ride();
        $ride_array = [];
        $filtered_rides = $rides::all()->map(function ($value, $key) use (&$ride_array) {
            if ($value->multi_date != null) {

                $arr = explode(', ', $value->multi_date);
                foreach ($arr as $item) {
                    array_push($ride_array, [
                        'id' => $value['id'],
                        'driver_id' => $value['driver_id'],
                        'car_id' => $value['car_id'],

                        'driver' => $value['driver'],
                        'car' => $value['car'],

                        'from' => $value['from'],
                        'to' => $value['to'],
                        'actual_reservation_nums' => $value['actual_reservation_nums'],
                        'time' => $value['time'],
                        'occurance' => $value['occurance'],
                        'once_date' => $value['once_date'],
                        'multi_date' => $item,
                        'waitting' => $value['waitting'],
                        'status' => $value['status'],
                        'created_at' => $value['created_at'],
                        'updated_at' => $value['updated_at'],
                    ]);
                }

                return $value;
            }

            array_push($ride_array, [
                'id' => $value['id'],
                'driver_id' => $value['driver_id'],
                'car_id' => $value['car_id'],

                'driver' => $value['driver'],
                'car' => $value['car'],

                'from' => $value['from'],
                'to' => $value['to'],
                'actual_reservation_nums' => $value['actual_reservation_nums'],
                'time' => $value['time'],
                'occurance' => $value['occurance'],
                'once_date' => $value['once_date'],
                'multi_date' => $value['multi_date'],
                'waitting' => $value['waitting'],
                'status' => $value['status'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ]);
            return $value;
        });

        // passenger id
        $passenger = \App\Models\Passenger::where('email', auth()->user()->email)->get()->all()[0];

        return view('pages.reserve.makeReserve', [
            'data' => [
                'rides' => collect($rides::all())->unique(function ($item) {
                    return $item['from'] . $item['to'];
                }),
                'passenger' => $passenger,
                'rides_json' => collect($ride_array)->toJson()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReserveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReserveRequest $request)
    {
        // init Ride Model
        $reserve = new \App\Models\Reserve();
        $ride = new \App\Models\Ride();
        $status_reserve = new \App\Models\StatusReserve();

        // get form request
        $validate = $request->validated();

        // filter validated request
        $filter_request = array_filter($validate, function ($item) {
            return $item != null || $item != '';
        });

        foreach ($filter_request as $key => $value) {
            $reserve->$key = $value;
        }

        DB::beginTransaction();
        try {
            // check if reserve num is biger than seats num
            $ride_seats = $ride::find($filter_request['ride_id']);
            if ($ride_seats->actual_reservation_nums >= $filter_request['num_of_seats_reserved']) {
                DB::table('rides')->decrement('actual_reservation_nums', $filter_request['num_of_seats_reserved']);
            } else {
                return back()->with('error', "عدد المقاعد المتوفرة $ride_seats->actual_reservation_nums فقط");
            }
            $reserve->save();

            // save to reserve_status table
            $amount = $ride::whereId($reserve->ride_id)->get()->all()[0];
            $status_reserve->ride_id = $reserve->ride_id;
            $status_reserve->passenger_id = $reserve->passenger_id;
            $status_reserve->reserve_id = $reserve->id;
            $status_reserve->total_amount = $amount->once_date == null ? ((count(explode(', ', $reserve->multi_dates)) * $reserve->num_of_seats_reserved) * $amount->amount) : ($amount->amount * $reserve->num_of_seats_reserved);

            $status_reserve->save();

            DB::commit();
            return back()->with('success', 'تم إنشاء الحجز بنجاح');
        } catch (\Exception $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function show(Reserve $reserve)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserve $reserve)
    {
        // $passenger_id = \App\Models\Passenger::where('email', auth()->user()->email)->get()->all()[0]->id;

        // init ride
        $rides = new \App\Models\Ride();
        $ride_array = [];
        $filtered_rides = $rides::all()->map(function ($value, $key) use (&$ride_array) {
            if ($value->multi_date != null) {

                $arr = explode(', ', $value->multi_date);
                foreach ($arr as $item) {
                    array_push($ride_array, [
                        'id' => $value['id'],
                        'driver_id' => $value['driver_id'],
                        'car_id' => $value['car_id'],

                        'driver' => $value['driver'],
                        'car' => $value['car'],

                        'from' => $value['from'],
                        'to' => $value['to'],
                        'actual_reservation_nums' => $value['actual_reservation_nums'],
                        'time' => $value['time'],
                        'occurance' => $value['occurance'],
                        'once_date' => $value['once_date'],
                        'multi_date' => $item,
                        'waitting' => $value['waitting'],
                        'status' => $value['status'],
                        'created_at' => $value['created_at'],
                        'updated_at' => $value['updated_at'],
                    ]);
                }

                return $value;
            }

            array_push($ride_array, [
                'id' => $value['id'],
                'driver_id' => $value['driver_id'],
                'car_id' => $value['car_id'],

                'driver' => $value['driver'],
                'car' => $value['car'],

                'from' => $value['from'],
                'to' => $value['to'],
                'actual_reservation_nums' => $value['actual_reservation_nums'],
                'time' => $value['time'],
                'occurance' => $value['occurance'],
                'once_date' => $value['once_date'],
                'multi_date' => $value['multi_date'],
                'waitting' => $value['waitting'],
                'status' => $value['status'],
                'created_at' => $value['created_at'],
                'updated_at' => $value['updated_at'],
            ]);
            return $value;
        });

        return view('pages.reserve.update', [
            'reserve' => $reserve,
            'data' => [
                'rides' => collect($rides::all())->unique(function ($item) {
                    return $item['from'] . $item['to'];
                }),
                'rides_json' => collect($ride_array)->toJson(),
                'reserve' => $reserve
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReserveRequest  $request
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReserveRequest $request, Reserve $reserve)
    {
        $ride = new \App\Models\Ride();
        $status_reserve = new \App\Models\StatusReserve();

        $validate = $request->validated();

        // filter inputs
        $filter_request = array_filter($validate, function ($value) {
            return $value != null || $value != '';
        });

        foreach ($filter_request as $key => $value) {
            $reserve->$key = $value;
            if ($key == 'once_date') {
                $reserve->multi_dates = null;
            }
            if ($key == 'multi_dates') {
                $reserve->once_date = null;
            }
        }

        DB::beginTransaction();
        try {
            $reserve->save();
            // check if reserve num is biger than seats num
            $ride_seats = $ride::find($reserve->ride_id);
            if ($ride_seats->actual_reservation_nums >= $reserve->num_of_seats_reserved) {
                DB::table('rides')->decrement('actual_reservation_nums', $reserve->num_of_seats_reserved);
            } else {
                return back()->with('error', "عدد المقاعد المتوفرة $ride_seats->actual_reservation_nums فقط");
            }

            // save to reserve_status table
            $amount = $ride::whereId($reserve->ride_id)->get()->all()[0];
            DB::table('status_reserves')->where(['passenger_id' =>  $reserve->passenger_id, 'ride_id' => $reserve->ride_id])->update(['total_amount' => $amount->once_date == null ? ((count(explode(', ', $reserve->multi_dates)) * $reserve->num_of_seats_reserved) * $amount->amount) : ($amount->amount * $reserve->num_of_seats_reserved)]);
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
     * @param  \App\Models\Reserve  $reserve
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserve $reserve)
    {
        // $ride = new \App\Models\Ride();

        $ride_id = $reserve->ride_id;

        try {
            // $ride::where('id', $ride_id)->increme('actual_reservation_nums', $reserve->num_of_seats_reserved);
            DB::table('rides')->where('id', $ride_id)->increment('actual_reservation_nums', $reserve->num_of_seats_reserved);
            $reserve->delete();
            return back()->with('success', 'تم الحذف بنجاح');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
            //throw $th;
        }
    }
}
