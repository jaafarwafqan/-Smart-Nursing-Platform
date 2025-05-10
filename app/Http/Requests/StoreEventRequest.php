<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_events');
    }

    public function rules(): array
    {
        $rules = [
            'branch_id'      => 'required|exists:branches,id',
            'activity_classification' => 'required|string|in:' . implode(',', config('types.activity_classifications')),
            'event_title'    => 'required|string|max:255',
            'event_datetime' => 'required|date',
            'location'       => 'required|string|max:255',
            'lecturers'      => 'nullable|string|max:255',
            'attendance'     => 'nullable|integer|min:0',
            'duration'       => 'nullable|integer|min:0',
            'description'    => 'nullable|string',
            'planned'        => 'boolean',
            'attachments.*'  => 'file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        ];

        // Add conditional validation for event_type
        if ($this->input('planned')) {
            $rules['event_type'] = 'required|string|in:' . implode(',', config('types.event_types'));
        } else {
            $rules['event_type'] = 'required|string|max:120';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'event_type.required' => 'نوع الفعالية مطلوب',
            'event_type.string' => 'نوع الفعالية يجب أن يكون نصاً',
            'event_type.in' => 'نوع الفعالية غير صالح',
            'event_type.max' => 'نوع الفعالية يجب أن لا يتجاوز 120 حرف',
            
            'activity_classification.required' => 'تصنيف النشاط مطلوب',
            'activity_classification.string' => 'تصنيف النشاط يجب أن يكون نصاً',
            'activity_classification.in' => 'تصنيف النشاط غير صالح',
            
            'event_title.required' => 'عنوان الفعالية مطلوب',
            'event_title.string' => 'عنوان الفعالية يجب أن يكون نصاً',
            'event_title.max' => 'عنوان الفعالية يجب أن لا يتجاوز 255 حرف',
            
            'event_datetime.required' => 'تاريخ ووقت الفعالية مطلوب',
            'event_datetime.date' => 'تاريخ ووقت الفعالية غير صالح',
            
            'location.required' => 'موقع الفعالية مطلوب',
            'location.string' => 'موقع الفعالية يجب أن يكون نصاً',
            'location.max' => 'موقع الفعالية يجب أن لا يتجاوز 255 حرف',
            
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع غير موجود',
            
            'lecturers.string' => 'أسماء المحاضرين يجب أن تكون نصاً',
            'lecturers.max' => 'أسماء المحاضرين يجب أن لا تتجاوز 255 حرف',
            
            'attendance.integer' => 'عدد الحضور يجب أن يكون رقماً',
            'attendance.min' => 'عدد الحضور يجب أن لا يقل عن 0',
            
            'duration.integer' => 'مدة الفعالية يجب أن تكون رقماً',
            'duration.min' => 'مدة الفعالية يجب أن لا تقل عن 0',
            
            'description.string' => 'وصف الفعالية يجب أن يكون نصاً',
            
            'attachments.*.file' => 'المرفق يجب أن يكون ملفاً',
            'attachments.*.mimes' => 'نوع الملف غير مدعوم. الأنواع المدعومة هي: PDF, DOC, DOCX, JPG, JPEG, PNG',
            'attachments.*.max' => 'حجم الملف يجب أن لا يتجاوز 4 ميجابايت'
        ];
    }
}
