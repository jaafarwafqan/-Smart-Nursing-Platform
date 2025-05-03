<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\researches;
class StoreResearchRequest extends FormRequest

{
    public function authorize(): bool
    {
        return $this->user()->can('manage_researches');
    }

    public function rules(): array
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'research_type' => 'required|string|max:120',
            'research_title' => 'required|string|max:255',
            'research_datetime' => 'required|date',
            'location' => 'required|string|max:255',
            'audience' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'planned' => 'boolean',
            'attachments.*' => 'file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        ];
    }
    public function messages(): array
    {
        return [
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع المحدد غير موجود',
            'research_type.required' => 'نوع البحث مطلوب',
            'research_type.string' => 'نوع البحث يجب أن يكون نصاً',
            'research_type.max' => 'نوع البحث يجب أن لا يتجاوز 120 حرف',
            'research_title.required' => 'عنوان البحث مطلوب',
            'research_title.string' => 'عنوان البحث يجب أن يكون نصاً',
            'research_title.max' => 'عنوان البحث يجب أن لا يتجاوز 255 حرف',
            'research_datetime.required' => 'تاريخ ووقت البحث مطلوب',
            'research_datetime.date' => 'تاريخ ووقت البحث غير صالح',
            'location.required' => 'موقع البحث مطلوب',
            'location.string' => 'موقع البحث يجب أن يكون نصاً',
            'location.max' => 'موقع البحث يجب أن لا يتجاوز 255 حرف',
            'audience.integer' => 'عدد الحضور يجب أن يكون رقماً',
            'audience.min' => 'عدد الحضور يجب أن لا يقل عن 0',
            'description.string' => 'وصف البحث يجب أن يكون نصاً',
            'planned.boolean' => 'التخطيط يجب أن يكون صحيحاً أو خاطئاً',
        ];
    }


}
