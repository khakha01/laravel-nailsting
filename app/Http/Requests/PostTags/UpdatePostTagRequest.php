<?php

namespace App\Http\Requests\PostTags;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:post_tags,slug,' . $this->route('post_tag'),
        ];
    }
}
