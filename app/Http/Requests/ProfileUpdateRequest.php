<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name' => 'nullable|string|max:191',
            'email' => 'nullable|string|unique:users,email|max:191',
            'address' => 'nullable|string|max:191',
            'phone' => 'nullable|string|max:191',
            'driver_license' => 'nullable|image|mimes:png,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'الإسم  يجب ان يكون نص',
            'name.max' => 'الإسم تعدى الطول المسموح للكتابة',

            'email.string' => 'الإيميل  يجب ان يكون نص',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل',
            'email.max' => 'الإيميل تعدى الطول المسموح للكتابة',

            'address.string' => 'العنوان  يجب ان يكون نص',
            'address.max' => 'العنوان تعدى الطول المسموح للكتابة',

            'phone.string' => 'رقم الهاتف  يجب ان يكون نص',
            'phone.max' => 'رقم الهاتف تعدى الطول المسموح للكتابة',

            'driver_license.image' => 'الرخصة يجب ان يكون صورة',
            'driver_license.mimes' => 'الرخصة يجب ان يكون ضمن الأنواع (png,jpg,jpeg)',
        ];
    }
}
