<?php

namespace App\Http\Requests\Banners;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'display_section' => 'nullable|string', // Just in case we want to categorize banners
            'media_id' => 'nullable|exists:media,id',
            'title' => 'nullable|string|max:255',
            'description_1' => 'nullable|string',
            'description_2' => 'nullable|string',
            'description_3' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'items' => 'nullable|array',
            'items.*.media_id' => 'nullable|exists:media,id',
            'items.*.title' => 'nullable|string|max:255',
            'items.*.description_1' => 'nullable|string',
            'items.*.description_2' => 'nullable|string',
            'items.*.description_3' => 'nullable|string',
            'items.*.button_text' => 'nullable|string|max:255',
            'items.*.button_link' => 'nullable|string|max:255',
            'items.*.is_active' => 'boolean',
        ];
    }
}
