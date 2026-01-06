<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CriteriaRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    //aturan pengisian
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'attribute' => ['required', Rule::in(['cost', 'benefit'])],
            'weight' => 'required|numeric|min:0|max:1',
            'column_ref' => 'required|string|max:50',
        ];
    }

    //pesan eror
    public function messages(): array
    {
        return [
            'code.required' => 'Kode kriteria wajib diisi',
            'name.required' => 'Nama kriteria wajib diisi',
            'attribute.required' => 'Atribut kriteria wajib diisi',
            'attribute.in' => 'Atribut harus berupa "cost" atau "benefit"',
            'weight.required' => 'Bobot kriteria wajib diisi',
            'weight.numeric' => 'Bobot harus berupa angka',
            'weight.min' => 'Bobot minimal 0',
            'weight.max' => 'Bobot maksimal 1',
            'column_ref.required' => 'Referensi kolom wajib diisi',
        ];
    }
}
