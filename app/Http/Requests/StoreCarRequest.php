<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            'driver_id' => 'nullable',
            'seats_num' => 'required|integer|max:18|min:2',
            'seat_price' => 'required|numeric',
            'car_license' => 'required|image|mimes:png,jpg,jpeg',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'driver_id.required' => 'الرجاء قم بإختيار السائق',
            'driver_id.exists' => 'السائق غير موجود في قاعدة البيانات',
            'seats_num.required' => 'عدد المقاعد مطلوب',
            'seats_num.integer' => 'عدد المقاعد ليس قيمة رقمية',
            'seats_num.max' => 'عدد المقاعد تجوز القيمة القصوى و هي 18',
            'seats_num.min' => 'أقل عدد مقاعد هو 2',
            'seat_price.required' => 'سعر المقعد مطلوب',
            'seat_price.numeric' => 'سعر المقعد ليس قيمة رقمية',
            'car_license.required' => 'رخصة السيارة مطلوبة',
            'car_license.image' => 'رخصة السيارة يجب ان يكون صورة',
            'car_license.mimes' => 'رخصة السيارة يجب ان يكون ضمن الأنواع (png,jpg,jpeg)',
            'user_id.required' => 'رقم المستخدم مطلوب',
            'user_id.exists' => 'رقم المستخدم غير موجود',
        ];
    }
}
