<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComparisonRequest extends FormRequest
{
    // pengecekan user
    public function authorize(): bool
    {
        return true;
    }

    //aturan pengisian
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'drink_ids' => 'required|array|min:2',
            'drink_ids.*' => 'exists:drinks,id',
            'notes' => 'nullable|string'
        ];
    }

    //pesan eror
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
