<?php

namespace App\Http\Livewire;

use App\Models\Reserve;
use Livewire\Component;

class MakeReserve extends Component
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

    public function submit()
    {
        $reserve = new Reserve();

        $validate = $this->validate(
            [
                'ride_id' => 'required|exists:rides,id',
                'passenger_id' => 'required|exists:passengers,id',
                'num_of_seats_reserved' => 'required|integer|min:1',
                'occurance' => 'required|string|in:once,custome',
                'once_date' => 'nullable|date',
                'multi_dates' => 'nullable|string',
            ],
            [
                'ride_id.required' => 'وجهة الرحلة مطلوبة',
                'ride_id.exists' => 'وجهة الرحلة غير موجودة في قاعدة البيانات',
                'passenger_id.required' => 'بيانات الراكب مطلوبة',
                'passenger_id.exists' => 'الراكب غير متوفر في قاعدة البيانات',
                'num_of_seats_reserved.required' => 'عدد المقاعد مطلوب',
                'num_of_seats_reserved.integer' => 'عدد المقاعد يجب ان يكون رقم',
                'num_of_seats_reserved.min' => 'اقل عدد للمقاعد يجب ان يكون 1',
                'occurance.required' => 'الفترة مطلوبة',
                'occurance.string' => 'الفترة يجب ان تكون نص',
                'occurance.in' => 'الفترة يجب ان تكون ضمن (once,custome)',
                'once_date.date' => 'تاريخ الوجهة يجب ان يكون تاريخ',
                'multi_dates.string' => 'التواريخ يجب ان تكون نص',
            ]
        );

        foreach ($validate as $key => $value) {
            $reserve->$key = $value;
        }

        try {
            $reserve->save();
            return back()->with('success', 'تم بنجاح');
        } catch (\Throwable $th) {
            return back()->with('erro', $th->getMessage());
        }

        // return redirect()->to('/reserve/create');
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
        // dd($this->data);
        return view('livewire.make-reserve', ['data' => $this->data]);
    }
}
