<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'desktop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'mobile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'order' => 'nullable'
        ];

        if ($this->isMethod('post')) {
            $rules['desktop_image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
            $rules['mobile_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        }

        return $rules;
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title_1.required' => 'The title field is required.',
            'desktop_image.required' => 'The image field is required for new sliders.',
            'desktop_image.image' => 'The file must be an image.',
            'desktop_image.mimes' => 'The image must be in jpeg, png, jpg, gif, or svg format.',
            'desktop_image.max' => 'The image size must not exceed 5MB.',
            'mobile_image.required' => 'The image field is required for new sliders.',
            'mobile_image.image' => 'The file must be an image.',
            'mobile_image.mimes' => 'The image must be in jpeg, png, jpg, gif, or svg format.',
            'mobile_image.max' => 'The image size must not exceed 5MB.',
            'title_2.max' => 'The subtitle may not be longer than 50 characters.',
            'caption.max' => 'The caption may not be longer than 191 characters.',
        ];
    }
}
