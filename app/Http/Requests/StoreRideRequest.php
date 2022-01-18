<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRideRequest extends FormRequest
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
            'driver_id' => 'required|exists:drivers,id',
            'car_id' => 'required|exists:cars,id',
            'actual_reservation_nums' => 'nullable|integer',
            'from' => 'required|string',
            'to' => 'required|string',
            'time' => 'required|date_format:H:i',
            'occurance' => 'required|string|in:once,custome',
            'once_date' => 'required_without:multi_date',
            'multi_date' => 'required_without:once_date',
        ];
    }

    public function messages()
    {
        return [
            'driver_id.required' => 'السائق مطلوب',
            'driver_id.exists' => 'السائق غير متوفر في قاعدة البيانات',
            'car_id.required' => 'السيارة مطلوبة',
            'car_id.exists' => 'السيارة غير متوفرة في قاعدة البيانات',
            'from.required' => 'الوجهة من مطلوبة',
            'from.string' => 'الوجهة يجب ان تكون عبارة عن نص',
            'to.required' => 'الوجهة إلى مطلوبة',
            'to.string' => 'الوجهة إلى يجب ان تكون نث',
            'time.required' => 'الوقت مطلوب',
            'time.date_format' => 'صيغة الوقت غير صحيحة',
            'occurance.required' => 'الفترة مطلوبة',
            'occurance.string' => 'الفترة يجب ان تكون نص',
            'occurance.in' => 'الفترة يجب ان تكون بين إحدى القيمتين (once,custome)',
            'once_date.required_without' => 'الرجاء إختيار احد التواريخ',
            'once_date.date' => 'تاريخ الوجهة يجب ان يكون موجود',
            'multi_date.string' => 'التواريخ يجب ان تكون نص',
            'multi_date.required_without' => 'الرجاء إختيار احد التواريخ',
        ];
    }
}
