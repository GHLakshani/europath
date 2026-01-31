<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'full_name'        => 'required|string|max:255',
            'nic'              => ['required','regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/'],
            'passport_no'      => 'nullable|string|max:50',
            'passport_expiry'  => 'nullable|date|after:today',
            'dob'              => 'required|date',
            'age'              => 'required|integer|min:18',
            'education'        => 'nullable|string|max:255',
            'experience_years'=> 'nullable|integer|min:0',
            'contact_number_1' => ['nullable', 'regex:/^\+?\d{7,15}$/'],
            'contact_number_2' => ['nullable', 'regex:/^\+?\d{7,15}$/'],



            'country_id'       => 'required|exists:countries,id',
            'job_id'           => 'required|exists:candidate_jobs,id',
            'agent_id'         => 'nullable|exists:agents,id',
            'sub_dealer_id'    => 'nullable|exists:sub_dealers,id',

            'photo'            => 'nullable|image|max:2048',

            'documents'        => 'array',
            'documents.*'      => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
        ];
    }
}
