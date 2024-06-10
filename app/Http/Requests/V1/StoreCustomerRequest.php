<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        return [
            'fullname' => ['required', 'string'],
            'email' => ['required', 'unique:customers,email', 'email'],
            'address' => ['required', 'string'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'starPoints' => ['required', 'sometimes', 'required', 'numeric', 'min:0'],
        ];
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
