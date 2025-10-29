<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'ate_on' => ['required','date'],
            'meal_type' => ['required','in:breakfast,lunch,dinner,snack'],
            'note' => ['nullable','string','max:1000'],
            'photo' => ['nullable','image','max:4096'],
            'items' => ['array'],
            'items.*.name' => ['nullable','string','max:100'],
            'items.*.quantity' => ['nullable','string','max:50'],
        ];
    }
}
