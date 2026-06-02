<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePeminjamanRequest extends FormRequest
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
            'alat_id' => ['required', 'exists:alats,id'],
            'tanggal_pinjam' => ['required', 'date', 'today_or_future'],
            'tanggal_kembali_rencana' => ['required', 'date', 'after:tanggal_pinjam'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'alat_id.required' => 'Alat yang akan dipinjam harus dipilih.',
            'alat_id.exists' => 'Alat tidak ditemukan.',
            'tanggal_pinjam.required' => 'Tanggal pinjam harus diisi.',
            'tanggal_kembali_rencana.after' => 'Tanggal kembali rencana harus setelah tanggal pinjam.',
        ];
    }
}
