<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // This can be modified as per your authentication logic
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'map_url' => 'nullable',
            'fax' => 'nullable|string|max:50',
            'mobile' => 'required',
            'whatsapp' => 'nullable',
            'facebook_link' => 'nullable|url',
            'youtube_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'x_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'address.required' => 'Address is required.',
            'address.string' => 'Address must be a string.',
            'address.max' => 'Address may not be greater than 255 characters.',
            'map_url.url' => 'Please provide a valid URL for the map.',
            'fax.max' => 'Fax number may not be greater than 50 characters.',
            'mobile1.required' => 'At least one mobile number is required.',
            'mobile1.numeric' => 'Mobile number must be numeric.',
            'mobile1.digits_between' => 'Mobile number must be between 10 and 15 digits.',
            'mobile2.numeric' => 'Mobile number must be numeric.',
            'mobile2.digits_between' => 'Mobile number must be between 10 and 15 digits.',
            'facebook_link.url' => 'Please provide a valid Facebook link.',
            'youtube_link.url' => 'Please provide a valid YouTube link.',
            'linkedin_link.url' => 'Please provide a valid LinkedIn link.',
            'x_link.url' => 'Please provide a valid X (Twitter) link.',
            'instagram_link.url' => 'Please provide a valid Instagram link.',
        ];
    }
}
