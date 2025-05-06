<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_teachers');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:teachers,email'],
            'phone' => ['required', 'string', 'max:20'],
            'branch_id' => ['required', 'exists:branches,id'],
            'specialization' => ['required', 'string', 'max:255'],
            'academic_rank' => ['required', 'string', 'max:100'],
            'hire_date' => ['required', 'date'],
            'attachments.*' => ['file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:4096'],
        ];
    }
} 