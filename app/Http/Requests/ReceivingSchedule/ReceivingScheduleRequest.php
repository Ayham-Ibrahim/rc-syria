<?php

namespace App\Http\Requests\ReceivingSchedule;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\ApiResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReceivingScheduleRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'receiving_point_id' => 'required|exists:receiving_points,id',
            'receiving_time' => 'required|date_format:Y/m/d H:i:s',
        ];
    }

       /**
     *  method handles failure of Validation and return message
     * @param \Illuminate\Contracts\Validation\Validator $Validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    protected function failedValidation(Validator $Validator)
    {
        $errors = $Validator->errors()->all();
        throw new HttpResponseException($this->errorResponse($errors, 'Validation error', 422));
    }
}
