<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportGuestsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|mimes:csv,txt,xlsx,xls|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File wajib diupload.',
            'file.mimes'    => 'Format file harus CSV, TXT, XLSX, atau XLS.',
            'file.max'      => 'Ukuran file maksimal 2MB.',
        ];
    }
}