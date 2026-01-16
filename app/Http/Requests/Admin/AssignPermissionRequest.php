<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AssignPermissionRequest extends FormRequest
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
            'permission_ids' => ['required', 'array', 'min:1'],
            'permission_ids.*' => ['integer', 'exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'permission_ids.required' => 'Vui lòng chọn ít nhất một quyền',
            'permission_ids.array' => 'Quyền phải là một mảng',
            'permission_ids.min' => 'Vui lòng chọn ít nhất một quyền',
            'permission_ids.*.exists' => 'Quyền không tồn tại',
        ];
    }
}
