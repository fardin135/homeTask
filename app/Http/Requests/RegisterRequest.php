<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiTraits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    use ApiTraits;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'in:User,Admin,SuperAdmin'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = $this->validationError(
            $validator->errors(),
        );
        throw new ValidationException($validator, $response);
    }
}
