<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileModify extends FormRequest
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
            "name" => "required|string|max:255",
            "email" => "nullable|email|max:255",
            "remark" => "nullable|string|max:255",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "會員名稱不可空白",
            "email.email" => "Email格式錯誤"
        ];
    }
}
