<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class UpdateOrderRequest extends FormRequest
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
		$statuses = implode(',', Item::getEnumValues('orders', 'status'));
        return [
			'address' => 'string|required',
			'customer_id' => 'numeric|required',
			'is_enabled' => 'boolean|required',
			'expired' => 'date|nullable',
			'status' => 'required|in:' . $statuses,
        ];
    }
}
