<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $nullableUrlFields = [
            'akad_map_link',
            'resepsi_map_link',
            'gift_map_link',
            'video_link',
        ];

        $normalized = [];

        foreach ($nullableUrlFields as $field) {
            $value = $this->input($field);

            if (is_string($value) && trim($value) === '#') {
                $normalized[$field] = null;
            }
        }

        if ($normalized !== []) {
            $this->merge($normalized);
        }
    }

    public function rules(): array
    {
        return [
            // Mempelai Pria
            'groom_name'       => 'required|string|max:255',
            'groom_nickname'   => 'nullable|string|max:100',
            'groom_father'     => 'nullable|string|max:255',
            'groom_mother'     => 'nullable|string|max:255',
            'groom_instagram'  => 'nullable|string|max:100',
            'groom_photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // Mempelai Wanita
            'bride_name'       => 'required|string|max:255',
            'bride_nickname'   => 'nullable|string|max:100',
            'bride_father'     => 'nullable|string|max:255',
            'bride_mother'     => 'nullable|string|max:255',
            'bride_instagram'  => 'nullable|string|max:100',
            'bride_photo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // Quote
            'quote'            => 'nullable|string|max:1000',

            // Cover & OG Image
            'cover_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'og_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // Music
            'music_file'       => 'nullable|mimes:mp3,wav,ogg|max:10240',

            // Akad
            'akad_title'       => 'nullable|string|max:255',
            'akad_datetime'    => 'nullable|date',
            'akad_location'    => 'nullable|string|max:255',
            'akad_address'     => 'nullable|string|max:500',
            'akad_map_link'    => 'nullable|url|max:500',
            'akad_province_name' => 'nullable|string|max:255',
            'akad_regency_name'  => 'nullable|string|max:255',
            'akad_district_name' => 'nullable|string|max:255',
            'akad_village_name'  => 'nullable|string|max:255',

            // Resepsi
            'resepsi_title'    => 'nullable|string|max:255',
            'resepsi_datetime' => 'nullable|date',
            'resepsi_location' => 'nullable|string|max:255',
            'resepsi_address'  => 'nullable|string|max:500',
            'resepsi_map_link' => 'nullable|url|max:500',
            'resepsi_province_name' => 'nullable|string|max:255',
            'resepsi_regency_name'  => 'nullable|string|max:255',
            'resepsi_district_name' => 'nullable|string|max:255',
            'resepsi_village_name'  => 'nullable|string|max:255',

            // Amplop / Gift
            'bank_name'        => 'nullable|string|max:255',
            'bank_number'      => 'nullable|string|max:50',
            'bank_holder'      => 'nullable|string|max:255',
            'gift_address'     => 'nullable|string|max:500',
            'gift_map_link'    => 'nullable|url|max:500',
            'qris_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'kado_province_name' => 'nullable|string|max:255',
            'kado_regency_name'  => 'nullable|string|max:255',
            'kado_district_name' => 'nullable|string|max:255',
            'kado_village_name'  => 'nullable|string|max:255',

            // Gallery
            'gallery_photos'   => 'nullable|array',
            'gallery_photos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'delete_gallery'   => 'nullable|array',
            'delete_gallery.*' => 'integer',

            // Video
            'video_link'       => 'nullable|url|max:500',

            // Love Stories
            'love_stories'               => 'nullable|array',
            'love_stories.*.year'        => 'nullable|string|max:10',
            'love_stories.*.title'       => 'nullable|string|max:255',
            'love_stories.*.story'       => 'nullable|string|max:2000',
            'love_stories.*.image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'groom_name.required' => 'Nama mempelai pria wajib diisi.',
            'bride_name.required' => 'Nama mempelai wanita wajib diisi.',
            '*.image'  => 'File harus berupa gambar (JPG, PNG, WebP).',
            '*.max'    => 'Ukuran file terlalu besar.',
            '*.url'    => 'Format URL tidak valid.',
        ];
    }
}