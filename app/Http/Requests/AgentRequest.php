<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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
            'name'            => ['required', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:255'],
            'nic'        => [
                'required',
                'regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/',
                Rule::unique('agents')->whereNull('deleted_at')
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'country_id.required' => 'Country is required.',
            'country_id.exists'   => 'Selected country is invalid.',
            'name.required'       => 'Agent name is required.',
            'email.email'         => 'Please enter a valid email address.',
            'nic.required' => 'NIC number is required.',
            'nic.regex'    => 'Please enter a valid NIC number (old or new format).',
            'nic.unique'   => 'This NIC number is already registered.',
        ];
    }
}
