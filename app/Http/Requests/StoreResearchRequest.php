<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Research;
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
            'research_title' => 'required|string|max:255',
            'research_type' => 'required|string|max:120',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => ['required', 'in:' . implode(',', array_keys(Research::getStatuses()))],
            'description' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع غير موجود',
            'research_title.required' => 'عنوان البحث مطلوب',
            'research_type.required' => 'نوع البحث مطلوب',
            'start_date.required' => 'تاريخ البدء مطلوب',
            'start_date.date' => 'تاريخ البدء غير صالح',
            'end_date.date' => 'تاريخ الانتهاء غير صالح',
            'end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء',
            'status.required' => 'حالة البحث مطلوبة',
            'status.in' => 'حالة البحث غير صالحة',
        ];
    }


}
