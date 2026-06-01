<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'max:256'],
            'email' => ['required', 'max:256'],
            'subject' => ['required', 'max:256'],
            'message' => ['required', 'max:256'],
            'blog_id' => ['required'],
        ];
    }

    #[Override]
    public function attributes()
    {
        return [
            'name' =>    'name',
            'email' =>   'email',
            'subject' => 'subject',
            'message' => 'message',
            'blog_id' => 'blog Id',
        ];
    }
}
