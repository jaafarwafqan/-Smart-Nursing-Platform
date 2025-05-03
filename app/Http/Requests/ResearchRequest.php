<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\researches;

class ResearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'researcher_id' => ['required', 'exists:users,id'],
            'supervisor_id' => ['required', 'exists:users,id'],
            'field_id' => ['required', 'exists:research_fields,id'],
            'stage_id' => ['required', 'exists:research_stages,id'],
            'status' => ['required', 'in:' . implode(',', array_keys(researches::getStatuses()))],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'expected_duration' => ['required', 'integer', 'min:1', 'max:60'],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:50'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240']
        ];

        // Additional validation for status changes
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $researches = $this->route('researches');
            if ($researches && $researches->status === researches::STATUS_COMPLETED) {
                $rules['status'] = ['required', 'in:' . researches::STATUS_COMPLETED];
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان البحث مطلوب',
            'title.max' => 'عنوان البحث يجب أن لا يتجاوز 255 حرف',
            'description.required' => 'وصف البحث مطلوب',
            'researcher_id.required' => 'الباحث مطلوب',
            'researcher_id.exists' => 'الباحث المحدد غير موجود',
            'supervisor_id.required' => 'المشرف مطلوب',
            'supervisor_id.exists' => 'المشرف المحدد غير موجود',
            'field_id.required' => 'مجال البحث مطلوب',
            'field_id.exists' => 'مجال البحث المحدد غير موجود',
            'stage_id.required' => 'مرحلة البحث مطلوبة',
            'stage_id.exists' => 'مرحلة البحث المحددة غير موجودة',
            'status.required' => 'حالة البحث مطلوبة',
            'status.in' => 'حالة البحث غير صالحة',
            'start_date.date' => 'تاريخ البدء يجب أن يكون تاريخاً صالحاً',
            'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخاً صالحاً',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء',
            'expected_duration.required' => 'المدة المتوقعة مطلوبة',
            'expected_duration.integer' => 'المدة المتوقعة يجب أن تكون رقماً صحيحاً',
            'expected_duration.min' => 'المدة المتوقعة يجب أن لا تقل عن شهر واحد',
            'expected_duration.max' => 'المدة المتوقعة يجب أن لا تتجاوز 60 شهراً',
            'keywords.array' => 'الكلمات المفتاحية يجب أن تكون مصفوفة',
            'keywords.*.string' => 'الكلمات المفتاحية يجب أن تكون نصوصاً',
            'keywords.*.max' => 'الكلمة المفتاحية يجب أن لا تتجاوز 50 حرف',
            'attachments.array' => 'المرفقات يجب أن تكون مصفوفة',
            'attachments.*.file' => 'المرفق يجب أن يكون ملفاً',
            'attachments.*.mimes' => 'نوع الملف غير مدعوم. الأنواع المدعومة هي: PDF, DOC, DOCX, JPG, JPEG, PNG',
            'attachments.*.max' => 'حجم الملف يجب أن لا يتجاوز 10 ميجابايت'
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('keywords') && is_string($this->keywords)) {
            $this->merge([
                'keywords' => array_map('trim', explode(',', $this->keywords))
            ]);
        }
    }
}
