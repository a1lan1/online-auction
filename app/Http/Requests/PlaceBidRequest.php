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
        $minPrice = $this->lot->current_price > 0
            ? $this->lot->current_price
            : $this->lot->starting_price;

        return [
            'amount' => [
                'required',
                'numeric',
                'decimal:0,2',
                'gt:'.$minPrice,
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('amount')) {
            $sanitizedAmount = filter_var(
                str_replace(',', '.', (string) $this->input('amount')),
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION
            );

            $truncatedAmount = floor((float) $sanitizedAmount * 100) / 100;

            $this->merge(['amount' => $truncatedAmount]);
        }
    }
}
