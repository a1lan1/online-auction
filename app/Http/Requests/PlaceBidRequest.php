<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlaceBidRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lot_id' => ['required', 'exists:lots,id'],
            'amount' => ['required', 'numeric', 'gt:0', 'min:'.$this->lot->current_price + 0.01],
        ];
    }
}
