<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_students');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email'],
            'phone' => ['required', 'string', 'max:20'],
            'branch_id' => ['required', 'exists:branches,id'],
            'student_id' => ['required', 'string', 'unique:students,student_id'],
            'enrollment_date' => ['required', 'date'],
            'graduation_year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'attachments.*' => ['file', 'mimes:pdf,doc,docx,png,jpg,jpeg', 'max:4096'],
        ];
    }
} 