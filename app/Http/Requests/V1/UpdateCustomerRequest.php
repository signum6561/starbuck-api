<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
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
        $method = $this->method();

        if ($method == 'PUT') {

            return [
                'fullname' => ['required', 'string'],
                'email' => ['required', 'email'],
                'address' => ['required', 'string'],
                'birthday' => ['required', 'date_format:Y-m-d'],
                'starPoints' => ['required', 'required', 'numeric', 'min:0'],
            ];
        } else {
            return [
                'fullname' => ['sometimes', 'required', 'string'],
                'email' => ['sometimes', 'required'],
                'address' => ['sometimes', 'required', 'string'],
                'birthday' => ['sometimes', 'required', 'date_format:Y-m-d'],
                'starPoints' => ['sometimes', 'required', 'numeric', 'min:0'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $stars = $this->starPoints;
        $type = ($stars >= 100) ? "Gold" : "Green";

        $this->merge([
            'star_points' => $this->starPoints,
            'type' => $type
        ]);
    }
}
