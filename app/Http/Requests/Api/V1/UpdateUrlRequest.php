<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateUrlRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'url' => [
                'required', 
                'url', 
                'max:2048',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'url.required' => 'The URL field is required.',
            'url.url'      => 'Please enter a valid URL format (e.g., https://google.com).',
        ];
    }
}

