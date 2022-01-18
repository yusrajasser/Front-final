<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReserveRequest extends FormRequest
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
            'ride_id' => 'nullable|exists:rides,id',
            'passenger_id' => 'nullable|exists:passengers,id',
            'num_of_seats_reserved' => 'nullable|integer|min:1',
            'occurance' => 'nullable|string|in:once,custome',
            'once_date' => 'nullable|date',
            'multi_dates' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'ride_id.exists' => 'وجهة الرحلة غير موجودة في قاعدة البيانات',
            'passenger_id.exists' => 'الراكب غير متوفر في قاعدة البيانات',
            'num_of_seats_reserved.integer' => 'عدد المقاعد يجب ان يكون رقم',
            'num_of_seats_reserved.min' => 'اقل عدد للمقاعد يجب ان يكون 1',
            'occurance.string' => 'الفترة يجب ان تكون نص',
            'occurance.in' => 'الفترة يجب ان تكون ضمن (once,custome)',
            'once_date.date' => 'تاريخ الوجهة يجب ان يكون تاريخ',
            'multi_dates.string' => 'التواريخ يجب ان تكون نص',
            'status.boolean' => 'حالة الحجز يجب ان تكون قيمة ثنائية',
        ];
    }
}
