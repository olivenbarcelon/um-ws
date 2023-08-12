<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest {
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
                'regex:/.+@[a-zA-Z]+\.com/',
                Rule::unique(User::RESOURCE_KEY, 'email')->whereNull('deleted_at')
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
            'email.unique' => 'Email has already been taken',
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
