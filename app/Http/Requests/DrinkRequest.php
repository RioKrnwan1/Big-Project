<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    //aturan pengisian
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'calories' => 'required|numeric|min:0|max:500',   
            'protein' => 'required|numeric|min:0|max:20',     
            'carbs' => 'required|numeric|min:0|max:60',         
            'fat' => 'required|numeric|min:0|max:20',         
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }

    // pesan eror
    public function messages(): array
    {
        return [
            'name.required' => 'Nama minuman wajib diisi',
            'calories.required' => 'Kalori wajib diisi',
            'calories.numeric' => 'Kalori harus berupa angka',
            'protein.required' => 'Kadar protein wajib diisi',
            'carbs.required' => 'Kadar karbohidrat wajib diisi',
            'fat.required' => 'Kadar lemak wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
