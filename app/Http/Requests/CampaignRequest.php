<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Campaign;

class CampaignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage_campaigns');
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(Campaign::getStatuses()))],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'branch' => ['required', 'string'],
            'organizers' => ['required', 'string'],
            'participants_count' => ['required', 'integer', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الحملة مطلوب',
            'title.max' => 'عنوان الحملة يجب أن لا يتجاوز 255 حرف',
            'status.required' => 'حالة الحملة مطلوبة',
            'status.in' => 'حالة الحملة غير صالحة',
            'start_date.required' => 'تاريخ بداية الحملة مطلوب',
            'start_date.date' => 'تاريخ بداية الحملة غير صالح',
            'end_date.required' => 'تاريخ نهاية الحملة مطلوب',
            'end_date.date' => 'تاريخ نهاية الحملة غير صالح',
            'end_date.after_or_equal' => 'تاريخ نهاية الحملة يجب أن يكون بعد تاريخ البداية',
            'branch.required' => 'الفرع مطلوب',
            'organizers.required' => 'المنظمون مطلوبون',
            'participants_count.required' => 'عدد المشاركين مطلوب',
            'participants_count.integer' => 'عدد المشاركين يجب أن يكون رقماً صحيحاً',
            'participants_count.min' => 'عدد المشاركين يجب أن يكون 1 على الأقل'
        ];
    }
} 