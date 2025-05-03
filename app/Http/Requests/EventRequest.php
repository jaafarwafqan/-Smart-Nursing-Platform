<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_type' => 'required|string|max:255',
            'event_title' => 'required|string|max:255',
            'event_datetime' => 'required|date',
            'location' => 'required|string|max:255',
            'branch' => 'required|string',
            'lecturers' => 'nullable|string',
            'attendance' => 'nullable|integer|min:0',
            'duration' => 'required|integer|min:0',
            'description' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ];
    }

    public function messages(): array
    {
        return [
            'event_type.required' => 'نوع الفعالية مطلوب',
            'event_type.string' => 'نوع الفعالية يجب أن يكون نصاً',
            'event_type.max' => 'نوع الفعالية يجب أن لا يتجاوز 255 حرف',
            
            'event_title.required' => 'عنوان الفعالية مطلوب',
            'event_title.string' => 'عنوان الفعالية يجب أن يكون نصاً',
            'event_title.max' => 'عنوان الفعالية يجب أن لا يتجاوز 255 حرف',
            
            'event_datetime.required' => 'تاريخ ووقت الفعالية مطلوب',
            'event_datetime.date' => 'تاريخ ووقت الفعالية غير صالح',
            
            'location.required' => 'موقع الفعالية مطلوب',
            'location.string' => 'موقع الفعالية يجب أن يكون نصاً',
            'location.max' => 'موقع الفعالية يجب أن لا يتجاوز 255 حرف',
            
            'branch.required' => 'الفرع مطلوب',
            'branch.string' => 'الفرع يجب أن يكون نصاً',
            
            'lecturers.string' => 'أسماء المحاضرين يجب أن تكون نصاً',
            
            'attendance.integer' => 'عدد الحضور يجب أن يكون رقماً',
            'attendance.min' => 'عدد الحضور يجب أن لا يقل عن 0',
            
            'duration.required' => 'مدة الفعالية مطلوبة',
            'duration.integer' => 'مدة الفعالية يجب أن تكون رقماً',
            'duration.min' => 'مدة الفعالية يجب أن لا تقل عن 0',
            
            'description.required' => 'وصف الفعالية مطلوب',
            'description.string' => 'وصف الفعالية يجب أن يكون نصاً',
            
            'attachments.*.file' => 'المرفق يجب أن يكون ملفاً',
            'attachments.*.mimes' => 'نوع الملف غير مدعوم. الأنواع المدعومة هي: PDF, DOC, DOCX, JPG, JPEG, PNG',
            'attachments.*.max' => 'حجم الملف يجب أن لا يتجاوز 10 ميجابايت'
        ];
    }
} 