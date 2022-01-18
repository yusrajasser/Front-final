<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomeStoreReserveRequest;
use App\Models\Reserve;
use App\Models\Ride;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomeStoreReserveController extends Controller
{
    public function checkIfReserveExists($data)
    {
        $reserve = new \App\Models\Reserve();

        $ride_arr = $data['ride_id'];

        // check if the ride is exists before
        $filter_data = collect($data)->except(['num_of_seats_reserved', 'ride_id'])->all();

        $arr = explode(', ', $filter_data['multi_dates']);

        if (isset($filter_data['multi_dates'])) {
            foreach ($arr as $key => $value) {
                $new_arr = collect($filter_data)->except(['multi_dates'])->put('multi_dates', $value)->put('ride_id', $ride_arr[$key])->all();
                // dd($new_arr);

                if (DB::table('reserves')->where($new_arr)->first()) {
                    return true;
                }
            }

            return false;
        } else {

            $count = $reserve::where($filter_data)->count();

            if ($count > 0) {
                return true;
            }

            return false;
        }
    }

    public function saveReserve($arr)
    {
        $reserve = new \App\Models\Reserve();
        $ride = new \App\Models\Ride();

        foreach ($arr as $key => $value) {
            $reserve->$key = $value;
        }

        if ($reserve->save()) {
            $amount = $ride::whereId($arr['ride_id'])->get()->all()[0];
            $this->saveReserveStatus([
                'reserve_id' => $reserve->id,
                'ride_id' => $arr['ride_id'],
                'passenger_id' => $arr['passenger_id'],
                'total_amount' => $amount->car['seat_price'] == null ? ((count(explode(', ', $reserve->multi_dates)) * $reserve->num_of_seats_reserved) * $amount->car['seat_price']) : ($amount->car['seat_price']  * $reserve->num_of_seats_reserved)
            ]);

            return true;
        } else {
            return throw new Error('حدثت مشكلة اثناء الحفظ');
        }
    }

    public function saveReserveStatus($arr)
    {
        $status_reserve = new \App\Models\StatusReserve();

        foreach ($arr as $key => $value) {
            $status_reserve->$key = $value;
        }

        if ($status_reserve->save()) {
            return true;
        } else {
            return throw new Error('حدثت مشكلة اثناء الحفظ');
        }
    }

    public function store(Request $request)
    {
        // init Ride Model
        $reserve = new \App\Models\Reserve();
        $ride = new \App\Models\Ride();
        $status_reserve = new \App\Models\StatusReserve();

        // get form request
        $validate = $request->validate([
            'ride_id' => 'required|array',
            'passenger_id' => 'required|exists:passengers,id',
            'num_of_seats_reserved' => 'required|integer|min:1',
            'occurance' => 'required|string|in:once,custome',
            'once_date' => 'required_without:multi_dates',
            'multi_dates' => 'required_without:once_date',
        ], [
            'ride_id.required' => 'وجهة الرحلة مطلوبة',
            'ride_id.array' => 'وجهة الرحلة غير موجودة في قاعدة البيانات',
            'passenger_id.required' => 'بيانات الراكب مطلوبة',
            'passenger_id.exists' => 'الراكب غير متوفر في قاعدة البيانات',
            'num_of_seats_reserved.required' => 'عدد المقاعد مطلوب',
            'num_of_seats_reserved.integer' => 'عدد المقاعد يجب ان يكون رقم',
            'num_of_seats_reserved.min' => 'اقل عدد للمقاعد يجب ان يكون 1',
            'occurance.required' => 'الفترة مطلوبة',
            'occurance.string' => 'الفترة يجب ان تكون نص',
            'occurance.in' => 'الفترة يجب ان تكون ضمن (once,custome)',
            'once_date.required_without' => 'الرجاء قم بإختيار احد التواريخ',
            'multi_dates.required_without' => 'الرجاء قم بإختيار أحد التواريخ',
        ]);

        // // filter validated request
        $filter_request = array_filter($validate, function ($item) {
            return $item != null || $item != '';
        });

        DB::beginTransaction();
        try {
            if ($this->checkIfReserveExists($filter_request)) {
                return response()->json([
                    'success' => false,
                    'message' => 'لقت قمت بحجز رحلة مماثلة من قبل بنفس البيانات'
                ], 200);
            }
            foreach ($filter_request['ride_id'] as $key => $value) {
                if (isset($filter_request['multi_dates'])) {
                    // check if reserve num is biger than seats num
                    $ride_seats = $ride::find($value);
                    if ($ride_seats->actual_reservation_nums >= $filter_request['num_of_seats_reserved']) {
                        DB::table('rides')->where('id', $value)->decrement('actual_reservation_nums', $filter_request['num_of_seats_reserved']);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => "عدد المقاعد المتوفرة $ride_seats->actual_reservation_nums فقط"
                        ], 200);
                    }

                    $this->saveReserve([
                        'ride_id' => $value,
                        'passenger_id' => $filter_request['passenger_id'],
                        'num_of_seats_reserved' => $filter_request['num_of_seats_reserved'],
                        'occurance' => $filter_request['occurance'],
                        'multi_dates' => explode(', ', $filter_request['multi_dates'])[$key]
                    ]);
                } else {
                    $ride_seats = $ride::find($value);
                    if ($ride_seats->actual_reservation_nums >= $filter_request['num_of_seats_reserved']) {
                        DB::table('rides')->where('id', $value)->decrement('actual_reservation_nums', $filter_request['num_of_seats_reserved']);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => "عدد المقاعد المتوفرة $ride_seats->actual_reservation_nums فقط"
                        ], 200);
                    }
                    $reserve->ride_id = $value;
                    $reserve->passenger_id = $filter_request['passenger_id'];
                    $reserve->num_of_seats_reserved = $filter_request['num_of_seats_reserved'];
                    $reserve->occurance = $filter_request['occurance'];
                    $reserve->once_date = $filter_request['once_date'];
                    $reserve->save();
                    // save to reserve_status table
                    $amount = $ride::whereId($reserve->ride_id)->get()->all()[0];
                    $status_reserve->ride_id = $reserve->ride_id;
                    $status_reserve->passenger_id = $reserve->passenger_id;
                    $status_reserve->reserve_id = $reserve->id;
                    $status_reserve->total_amount = $amount->car['seat_price'] == null ? ((count(explode(', ', $reserve->multi_dates)) * $reserve->num_of_seats_reserved) * $amount->car['seat_price']) : ($amount->car['seat_price']  * $reserve->num_of_seats_reserved);

                    $status_reserve->save();
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'تم بنجاح'
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 200);
        }
    }

    public function updateReserveStatus($reserve)
    {
        $rideModel = \App\Models\Ride::find($reserve->ride_id);
        // dd($rideModel);
        $status_reserve_id = \App\Models\StatusReserve::where('reserve_id', $reserve->id)->get()->all()[0]->id;
        // dd($status_reserve_id);
        $statusReserveModel = \App\Models\StatusReserve::find($status_reserve_id);
        // save to reserve_status table

        $statusReserveModel->total_amount = ($rideModel->car['seat_price'] * $reserve->num_of_seats_reserved);
        if ($statusReserveModel->save()) {
            return true;
        }
        return false;
    }

    public function updateSeatsNum($ride, $reserve, $value)
    {
        $ride = \App\Models\Ride::find($ride);

        // return back old reserve seats number
        $old_seats_num = $reserve->num_of_seats_reserved;
        DB::table('rides')->where('id', $ride->id)->increment('actual_reservation_nums', $old_seats_num);

        // update ride seats with the new seats
        if (($old_seats_num + $ride['actual_reservation_nums']) >= $value['num_of_seats_reserved']) {
            DB::table('rides')->where('id', $ride->id)->decrement('actual_reservation_nums', $value['num_of_seats_reserved']);
            return true;
        } else {
            return false;
        }
    }

    public function updateReserve($id, $arr)
    {
        $reserve = \App\Models\Reserve::find($id);

        foreach ($arr as $key => $value) {
            if (isset($arr['num_of_seats_reserved']) && isset($arr['ride_id'])) {

                if ($this->updateSeatsNum($arr['ride_id'], $reserve, $arr) != true) {
                    return response()->json([
                        'success' => false,
                        'message' => "هذا العدد من المقاعد غير متوفر"
                    ], 200);
                }

                $reserve->$key = $value;
                if (isset($arr['multi_dates'])) {
                    $reserve->once_date = null;
                }
                if (isset($arr['once_date'])) {
                    $reserve->multi_dates = null;
                }

                try {
                    $reserve->save();
                    $this->updateReserveStatus($reserve);
                    return $reserve;
                } catch (\Throwable $th) {
                    return false;
                }
            } else {

                if (isset($arr['num_of_seats_reserved'])) {
                    if ($this->updateSeatsNum($reserve->ride_id, $reserve, $arr) != true) {
                        return response()->json([
                            'success' => false,
                            'message' => "هذا العدد من المقاعد غير متوفر"
                        ], 200);
                    }
                    $reserve->$key = $value;
                    if (isset($arr['multi_dates'])) {
                        $reserve->once_date = null;
                    }
                    if (isset($arr['once_date'])) {
                        $reserve->multi_dates = null;
                    }

                    try {
                        $reserve->save();
                        $this->updateReserveStatus($reserve);
                        return $reserve;
                    } catch (\Throwable $th) {
                        return false;
                    }
                }
            }
        }
    }

    public function update(Request $request, $id)
    {
        $reserve = \App\Models\Reserve::find($id);
        $ride = new \App\Models\Ride();
        $status_reserve = \App\Models\StatusReserve::where('reserve_id', $id);

        $validate = $request->validate(
            [
                'ride_id' => 'nullable|exists:rides,id',
                'num_of_seats_reserved' => 'nullable|integer|min:1',
                'occurance' => 'nullable|string|in:once,custome',
                'once_date' => 'nullable|date',
                'multi_dates' => 'nullable|string',
                'status' => 'nullable|boolean',
            ],
            [
                'ride_id.exists' => 'وجهة الرحلة غير موجودة في قاعدة البيانات',
                'num_of_seats_reserved.integer' => 'عدد المقاعد يجب ان يكون رقم',
                'num_of_seats_reserved.min' => 'اقل عدد للمقاعد يجب ان يكون 1',
                'occurance.string' => 'الفترة يجب ان تكون نص',
                'occurance.in' => 'الفترة يجب ان تكون ضمن (once,custome)',
                'once_date.date' => 'تاريخ الوجهة يجب ان يكون تاريخ',
                'multi_dates.string' => 'التواريخ يجب ان تكون نص',
                'status.boolean' => 'حالة الحجز يجب ان تكون قيمة ثنائية',
            ]
        );

        // // filter validated request
        $filter_request = array_filter($validate, function ($item) {
            return $item != null || $item != '';
        });

        $filtered_collection = collect($filter_request)->except(['ride_id']);

        // DB::beginTransaction();
        try {

            if (isset($filter_request['ride_id'])) {
                foreach ($filter_request['ride_id'] as $key => $value) {
                    $new = collect($filtered_collection)->put('ride_id', $value);

                    $result = $this->updateReserve($id, $new->all());

                    return response()->json([
                        'success' => true,
                        'message' => 'تم بنجاح',
                        'data' => $result
                    ], 200);
                }
            } else {
                if (isset($filter_request['num_of_seats_reserved'])) {
                    $result = $this->updateReserve($id, $filter_request);

                    return response()->json([
                        'success' => true,
                        'message' => 'تم بنجاح',
                        'data' => $result
                    ], 200);
                    // dd('dump');
                } else {
                    $reserve->update($filter_request);
                }
            }

            // DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'تم بنجاح'
            ], 200);
        } catch (\Exception $th) {
            // DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 200);
        }
    }
}
