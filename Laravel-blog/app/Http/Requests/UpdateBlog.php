<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlog extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'category',
        ];
    }
}

