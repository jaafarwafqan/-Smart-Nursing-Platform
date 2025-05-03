<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('edit_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'branch_id' => 'required|exists:branches,id',
            'type' => 'required|in:professor,student,supervisor',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم المستخدم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع غير موجود',
            'type.required' => 'نوع المستخدم مطلوب',
            'type.in' => 'نوع المستخدم غير صالح',
            'roles.required' => 'الأدوار مطلوبة',
            'roles.min' => 'يجب اختيار دور واحد على الأقل',
            'roles.*.exists' => 'الدور غير موجود',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'اسم المستخدم',
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
            'branch_id' => 'الفرع',
            'type' => 'نوع المستخدم',
            'roles' => 'الأدوار',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('password') !== $this->input('password_confirmation')) {
                $validator->errors()->add('password_confirmation', 'تأكيد كلمة المرور غير متطابق');
            }
        });
    }

    public function prepareForValidation()
    {
        $this->merge([
            'branch_id' => $this->branch_id ?? auth()->user()->branch_id,
        ]);
    }

    public function passedValidation()
    {
        $this->merge([
            'name' => trim($this->name),
            'email' => trim($this->email),
        ]);
    }

    public function failedValidation($validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }

    public function response(array $errors)
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
        ], 422);
    }
}
