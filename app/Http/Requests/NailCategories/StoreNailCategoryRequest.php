<?php

namespace App\Http\Requests\NailCategories;

use Illuminate\Foundation\Http\FormRequest;

class StoreNailCategoryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:nail_categories,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:nail_categories,slug'],
            'parent_id' => ['nullable', 'integer', 'exists:nail_categories,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục nail là bắt buộc',
            'name.max' => 'Tên danh mục nail không được vượt quá 255 ký tự',
            'name.unique' => 'Tên danh mục nail đã tồn tại',
            'slug.required' => 'Slug là bắt buộc',
            'slug.unique' => 'Slug đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không tồn tại',
        ];
    }
}

