<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules() {
        return [
            'email' => [
                'required',
                'regex:/.+@[a-zA-Z]+\.\S{3}/',
                Rule::exists(User::RESOURCE_KEY, 'email')->whereNull('deleted_at')
            ],
            'password' => [
                'required'
            ]
        ];
    }

    /**
     * @return void
     */
    public function messages() {
        return [
            'email.required' => 'Email is required',
            'email.regex' => 'Email format is invalid',
            'email.exists' => 'Email does not exist',
            'password.required' => 'Password is required'
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
