<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponse::response(422, "Validation Error", $validator->errors());
            throw new \Illuminate\Validation\ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:8', 'max:256'],
            'description' => ['required', 'string', 'max:256'],
            'image' => ['required', 'image'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'name',
            'description' => 'description',
            'image' => 'image',
            'category_id' => 'category id ',
        ];
    }
}
