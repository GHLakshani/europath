<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            'country_id'      => ['required', 'exists:countries,id'],
            'title'            => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Country is required.',
            'country_id.exists'   => 'Selected country is invalid.',
            'title.required'       => 'Job is required.',
        ];
    }
}
