<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'passenger_id' => 'nullable|exists:passengers,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'ride_id' => 'required|exists:rides,id',
            'message' => 'required|string|max:191'
        ];
    }

    public function messages()
    {
        return [
            'ride_id.required' => 'وجهة الرحلة مطلوبة',
            'ride_id.exists' => 'وجهة الرحلة غير موجودة في قاعدة البيانات',
            'passenger_id.exists' => 'الراكب غير متوفر في قاعدة البيانات',
            'driver_id.exists' => 'السائق غير متوفر في قاعدة البيانات',
            'message.required' => 'الرسالة مطلوبة',
            'message.string' => 'الرسالة يجب ان تكون نص',
        ];
    }
}
