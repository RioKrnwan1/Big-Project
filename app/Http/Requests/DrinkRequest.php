<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for validating Drink data
 */
class DrinkRequest extends FormRequest
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
            'calories' => 'required|numeric|min:0|max:500',     // Max 500 kcal untuk minuman 250ml
            'protein' => 'required|numeric|min:0|max:20',       // Max 20g (susu protein tinggi)
            'carbs' => 'required|numeric|min:0|max:60',         // Max 60g (smoothie/juice manis)
            'fat' => 'required|numeric|min:0|max:20',           // Max 20g (cream/susu full fat)
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }

    /**
     * Get custom validation messages
     */
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
