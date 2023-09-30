<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourListRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'priceFrom' => 'nullable|numeric|min:0',
            'priceTo' => 'nullable|numeric|min:0',
            'dateFrom' => 'nullable|date',
            'dateTo' => 'nullable|date',
            'orderBy' => Rule::in(['price', 'starting_date']),
            'orderDirection' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return [
            'priceFrom.numeric' => 'The price from must be a number',
            'priceFrom.min' => 'The price from must be at least 0',
            'priceTo.numeric' => 'The price to must be a number',
            'priceTo.min' => 'The price to must be at least 0',
            'dateFrom.date' => 'The date from must be a date',
            'dateTo.date' => 'The date to must be a date',
            'orderBy' => 'The order by must be one of price, starting_date',

        ];
    }
}
