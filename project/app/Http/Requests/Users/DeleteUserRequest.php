<?php

namespace App\Http\Requests\Users;

use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;

class DeleteUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'uuid' => [
                'required',
                'uuid',
                Rule::exists(User::RESOURCE_KEY, 'uuid')->whereNull('deleted_at')
            ]
        ];
    }

    /**
     * @return void
     */
    public function messages() {
        return [
            'uuid.required' => 'UUID is required',
            'uuid.uuid' => 'UUID must be a valid UUID',
            'uuid.exists' => 'UUID does not exist'
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation() {
        $this->merge(['uuid' => $this->route('uuid')]);
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
