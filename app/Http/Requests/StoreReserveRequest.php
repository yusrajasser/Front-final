<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReserveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ride_id' => 'required|exists:rides,id',
            'passenger_id' => 'required|exists:passengers,id',
            'num_of_seats_reserved' => 'required|integer|min:1',
            'occurance' => 'required|string|in:once,custome',
            'once_date' => 'nullable|date',
            'multi_dates' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
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
        ];
    }
}
