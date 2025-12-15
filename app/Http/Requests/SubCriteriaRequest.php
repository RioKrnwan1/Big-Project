<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for validating SubCriteria data
 */
class SubCriteriaRequest extends FormRequest
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
            'criteria_id' => 'required|exists:criterias,id',
            'range_min' => 'required|numeric|min:0',
            'range_max' => 'required|numeric|min:0|gt:range_min',
            'value' => 'required|integer|min:1|max:5',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'criteria_id.required' => 'Kriteria wajib dipilih',
            'criteria_id.exists' => 'Kriteria yang dipilih tidak valid',
            'range_min.required' => 'Rentang minimum wajib diisi',
            'range_min.numeric' => 'Rentang minimum harus berupa angka',
            'range_max.required' => 'Rentang maksimum wajib diisi',
            'range_max.numeric' => 'Rentang maksimum harus berupa angka',
            'range_max.gt' => 'Rentang maksimum harus lebih besar dari minimum',
            'value.required' => 'Nilai skala wajib diisi',
            'value.integer' => 'Nilai skala harus berupa bilangan bulat',
            'value.min' => 'Nilai skala minimal 1',
            'value.max' => 'Nilai skala maksimal 5',
        ];
    }
}
