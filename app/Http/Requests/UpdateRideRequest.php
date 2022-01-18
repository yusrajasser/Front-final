<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRideRequest extends FormRequest
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
            'car_id' => 'nullable|exists:cars,id',
            'actual_reservation_nums' => 'nullable|integer',
            'from' => 'nullable|string',
            'to' => 'nullable|string',
            'time' => 'nullable|date_format:H:i',
            // 'amount' => 'nullable|numeric',
            'occurance' => 'nullable|string|in:once,custome',
            'once_date' => 'nullable|date',
            'multi_date' => 'nullable|string',
            'status' => 'nullable|in:waiting,done,canceled',
        ];
    }

    public function messages()
    {
        return [
            'driver_id.exists' => 'السائق غير متوفر في قاعدة البيانات',
            'car_id.exists' => 'السيارة غير متوفرة في قاعدة البيانات',
            'from.string' => 'الوجهة يجب ان تكون عبارة عن نص',
            'to.string' => 'الوجهة إلى يجب ان تكون نث',
            'time.date_format' => 'صيغة الوقت غير صحيحة',
            // 'amount.numeric' => 'المبلغ يجب ان يكون أرقام',
            'occurance.string' => 'الفترة يجب ان تكون نص',
            'occurance.in' => 'الفترة يجب ان تكون بين إحدى القيمتين (once,custome)',
            'once_date.date' => 'تاريخ الوجهة يجب ان يكون تاريخ',
            'multi_date.string' => 'التواريخ يجب ان تكون نص',
            'status.in' => 'يجب ان تكون الحالة ضمن (إنتظار, تم, إلغاء)',
        ];
    }
}
