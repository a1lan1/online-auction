<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutocompleteLotRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => ['nullable', 'string', 'max:255'],
        ];
    }
}
