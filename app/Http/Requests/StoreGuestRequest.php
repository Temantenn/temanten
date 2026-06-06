<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'whatsapp'  => 'nullable|string|max:20',
            'category'  => 'nullable|string|max:100',
            'address'   => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tamu wajib diisi.',
            'name.max'      => 'Nama tamu maksimal 255 karakter.',
        ];
    }
}