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
            'sugar' => 'required|numeric|min:0|max:1000',
            'calories' => 'required|numeric|min:0|max:5000',
            'fat' => 'required|numeric|min:0|max:500',
            'protein' => 'required|numeric|min:0|max:500',
            'carbs' => 'required|numeric|min:0|max:1000',
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
            'sugar.required' => 'Kadar gula wajib diisi',
            'sugar.numeric' => 'Kadar gula harus berupa angka',
            'sugar.min' => 'Kadar gula tidak boleh negatif',
            'calories.required' => 'Kalori wajib diisi',
            'calories.numeric' => 'Kalori harus berupa angka',
            'fat.required' => 'Kadar lemak wajib diisi',
            'protein.required' => 'Kadar protein wajib diisi',
            'carbs.required' => 'Kadar karbohidrat wajib diisi',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, atau gif',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
