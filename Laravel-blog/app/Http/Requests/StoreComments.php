<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StoreComments extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
            'blog_id' => 'required|exists:blogs,id',
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'Please enter your name.',
        'email.unique' => 'You have already commented on this post.',
        'message.required' => 'The message field cannot be empty.',
    ];
}

}

