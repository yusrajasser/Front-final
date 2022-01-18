<?php

namespace App\Http\Livewire;

use App\Models\Reserve;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UpdateReserve extends Component
{
    public $count = 1;
    public $data;
    public $selectRide;
    public $uniqueDates;

    public function increment()
    {
        if ($this->count >= 18) {
            $this->count;
        } else {
            $this->count++;
        }
    }

    public function decrement()
    {
        if ($this->count <= 1) {
            $this->count;
        } else {
            $this->count--;
        }
    }

    public function submit($id)
    {
        $reserve = \App\Models\Reserve::find($id);
        $ride = new \App\Models\Ride();
        $status_reserve = new \App\Models\StatusReserve();

        $validate = $this->validate(
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

        DB::beginTransaction();
        try {

            if (isset($filter_request['ride_id'])) {

                foreach ($filter_request['ride_id'] as $key => $value) {
                    if (isset($filter_request['multi_dates'])) {
                        // check if reserve num is biger than seats num
                        $ride_seats = $ride::find($value);
                        if (isset($filter_request['num_of_seats_reserved'])) {
                            if ($ride_seats->actual_reservation_nums >= $filter_request['num_of_seats_reserved']) {
                                DB::table('rides')->decrement('actual_reservation_nums', $filter_request['num_of_seats_reserved']);
                            } else {
                                return response()->json([
                                    'success' => false,
                                    'message' => "عدد المقاعد المتوفرة $ride_seats->actual_reservation_nums فقط"
                                ], 200);
                            }
                        }

                        $reserve->ride_id = $value;
                        $reserve->num_of_seats_reserved = $filter_request['num_of_seats_reserved'];
                        $reserve->occurance = $filter_request['occurance'];
                        $reserve->multi_dates = explode(', ', $filter_request['multi_dates'])[$key];
                        $reserve->save();
                        // save to reserve_status table
                        $amount = $ride::whereId($reserve->ride_id)->get()->all()[0];
                        $status_reserve->ride_id = $reserve->ride_id;
                        $status_reserve->passenger_id = $reserve->passenger_id;
                        $status_reserve->reserve_id = $reserve->id;
                        $status_reserve->total_amount = $amount->car['seat_price'] == null ? ((count(explode(', ', $reserve->multi_dates)) * $reserve->num_of_seats_reserved) * $amount->car['seat_price']) : ($amount->car['seat_price']  * $reserve->num_of_seats_reserved);

                        $status_reserve->save();
                    } else {
                        $ride_seats = $ride::find($value);
                        if ($ride_seats->actual_reservation_nums >= $filter_request['num_of_seats_reserved']) {
                            DB::table('rides')->decrement('actual_reservation_nums', $filter_request['num_of_seats_reserved']);
                        } else {
                            return response()->json([
                                'success' => false,
                                'message' => "عدد المقاعد المتوفرة $ride_seats->actual_reservation_nums فقط"
                            ], 200);
                        }
                        $reserve->ride_id = $filter_request['ride_id'];
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

    public function updatedSelectRide($value)
    {
        $ride = new \App\Models\Ride();

        // get selected ride value and transform it to an array
        $arr_of_rides = explode(',', $value);
        // search for the selected ride in ride table
        $dates_in_array = [];
        $dates_results = collect($ride::where(['from' => $arr_of_rides[0], 'to' => $arr_of_rides[1]])->get()->all())->each(function ($value) use (&$dates_in_array) {
            if ($value['multi_date']) {
                $arr = explode(', ', $value['multi_date']);
                foreach ($arr as $date) {
                    array_push($dates_in_array, $date);
                }
            } else {
                array_push($dates_in_array, $value['once_date']);
            }
            return $value;
        });

        // dates
        $unique_dates = collect($dates_in_array)->unique()->values();

        $this->uniqueDates = collect($unique_dates)->toJson();
    }

    public function render()
    {
        return view('livewire.update-reserve', ['data' => $this->data]);
    }
}
