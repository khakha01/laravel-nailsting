<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $categoryId . ',id'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $categoryId . ',id'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', 'different:id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục là bắt buộc',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'slug.required' => 'Slug là bắt buộc',
            'slug.unique' => 'Slug đã tồn tại',
            'parent_id.exists' => 'Danh mục cha không tồn tại',
            'parent_id.different' => 'Danh mục cha không được giống với danh mục hiện tại',
            'is_active.required' => 'Trạng thái là bắt buộc',
            'display_order.integer' => 'Thứ tự hiển thị phải là số',
        ];
    }
}
