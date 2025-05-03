<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_users');
    }

    public function rules(): array
    {
        $id = $this->route('user')?->id;   // عند التحديث

        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,'.($id ?? 'NULL').',id',
            'password'  => $id ? 'nullable|string|min:6|confirmed' : 'required|string|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id',
            'roles'     => 'array',
            'roles.*'   => 'exists:roles,name',
        ];
    }
}
