<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:5',
                'max:100',
                'regex:/^[\p{Arabic}\s]+$/u',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'يرجى إدخال الاسم الكامل.',
            'name.min' => 'يجب أن يتكون الاسم الكامل من 5 أحرف على الأقل.',
            'name.max' => 'يجب ألا يتجاوز الاسم الكامل 100 حرف.',
            'name.regex' => 'يرجى كتابة الاسم الكامل باللغة العربية فقط (بدون أرقام أو حروف أجنبية).',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الاسم الكامل',
        ];
    }
}
