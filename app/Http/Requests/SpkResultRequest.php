<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpkResultRequest extends FormRequest
{
    //pengecekan user
    public function authorize(): bool
    {
        return true;
    }

    //aturan pengisian
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ];
    }

    //pesan eror jika validasi ga sesuai
    public function messages(): array
    {
        return [
            'name.required' => 'Nama hasil SPK harus diisi'
        ];
    }
}
