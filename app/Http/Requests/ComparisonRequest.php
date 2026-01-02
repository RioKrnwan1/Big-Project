<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComparisonRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'drink_ids' => 'required|array|min:2',
            'drink_ids.*' => 'exists:drinks,id',
            'notes' => 'nullable|string'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama perbandingan harus diisi',
            'drink_ids.required' => 'Pilih minimal 2 minuman untuk dibandingkan',
            'drink_ids.min' => 'Pilih minimal 2 minuman untuk dibandingkan',
            'drink_ids.*.exists' => 'Minuman yang dipilih tidak valid'
        ];
    }
}
