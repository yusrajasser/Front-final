<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'driver_id' => 'nullable|exists:drivers,id',
            'seats_num' => 'nullable|integer',
            'seat_price' => 'nullable|numeric',
            'car_license' => 'nullable|image|mimes:png,jpg,jpeg'
        ];
    }

    public function messages()
    {
        return [
            'driver_id.exists' => 'السائق غير موجود في قاعدة البيانات',
            'seats_num.integer' => 'عدد المقاعد ليس قيمة رقمية',
            'seat_price.numeric' => 'سعر المقعد ليس قيمة رقمية',
            'car_license.image' => 'رخصة السيارة يجب ان يكون صورة',
            'car_license.mimes' => 'رخصة السيارة يجب ان يكون ضمن الأنواع (png,jpg,jpeg)',
        ];
    }
}
