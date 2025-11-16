<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDistributorItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'id' => 'numeric|required',
			'count' => 'numeric|required',
			'delivery' => 'string|max:255|nullable',
			'discount' => 'numeric|nullable',
			'is_enabled' => 'boolean',
			'url' => 'string|max:255|nullable',
			'price' => 'decimal:2,8',

        ];
    }
}
