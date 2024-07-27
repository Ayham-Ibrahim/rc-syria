<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserInfoRequest extends FormRequest
{
    use ApiResponseTrait;

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
            'full_name' => 'nullable|string|min:2',
            'phone_number' =>'nullable|numeric|min:8|max:11',
            'id_number'=> 'nullable|numeric|min:8|max:12',
            'address'=> 'nullable|string|min:2',
            'status'=> ['nullable',Rule::in(['متزوج','أعزب'])],
            'age'=> 'nullable|numeric',
            'category_id'=> 'nullable|integer|exists:categories,id',
        ];
    }

    /**
     *  method handles failure of Validation and return message
     * @param \Illuminate\Contracts\Validation\Validator $Validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $Validator){
        $errors = $Validator->errors()->all();
        throw new HttpResponseException($this->errorResponse($errors,'Validation error',422));
    }
}
