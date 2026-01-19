<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // You can customize this based on user permissions
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            // 'subcategory_id' => 'required|exists:sub_categories,id', // Ensure subcategory exists
        ];
    }
}
