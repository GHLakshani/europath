<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubDealerRequest extends FormRequest
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
            'name'            => ['required', 'string', 'max:255'],
            'nic'        => [
                'required',
                'regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/',
                Rule::unique('agents')->whereNull('deleted_at')
            ],
            'phone'           => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Agent name is required.',
            'nic.required' => 'NIC number is required.',
            'nic.regex'    => 'Please enter a valid NIC number (old or new format).',
            'nic.unique'   => 'This NIC number is already registered.',
        ];
    }
}
