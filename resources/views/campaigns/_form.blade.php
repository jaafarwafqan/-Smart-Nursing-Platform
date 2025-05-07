@props(['campaign'=>null,'branches'])
@php $isEdit=!is_null($campaign); @endphp


<x-form.select name="branch_id" label='<i class="fas fa-code-branch text-muted ms-1"></i> الفرع'>
    @foreach($branches as $id => $name)
        <option value="{{ $id }}" @selected(old('branch_id', $campaign->branch_id ?? '')==$id)>{{ $name }}</option>
    @endforeach
</x-form.select>

<x-form.input name="campaign_title" label='<i class="fas fa-heading text-muted ms-1"></i> عنوان الحملة'
              :value="old('campaign_title',$campaign->campaign_title??'')" />

<x-form.select name="status" label='<i class="fas fa-tasks text-muted ms-1"></i> حالة الحملة'>
    <option value="pending" @selected(old('status', $campaign->status ?? '') == 'pending')>قيد الانتظار</option>
    <option value="active" @selected(old('status', $campaign->status ?? '') == 'active')>نشطة</option>
    <option value="completed" @selected(old('status', $campaign->status ?? '') == 'completed')>مكتملة</option>
</x-form.select>

<x-form.input type="date" name="start_date" label='<i class="fas fa-calendar-alt text-muted ms-1"></i> تاريخ البداية'
              :value="old('start_date', $campaign->start_date ?? '')" />

<x-form.input type="date" name="end_date" label='<i class="fas fa-calendar-check text-muted ms-1"></i> تاريخ النهاية'
              :value="old('end_date', $campaign->end_date ?? '')" />

<x-form.input name="organizers" label='<i class="fas fa-users text-muted ms-1"></i> المنظمون'
              :value="old('organizers', $campaign->organizers ?? '')" />

<x-form.input name="participants_count" label='<i class="fas fa-user-friends text-muted ms-1"></i> عدد المشاركين' type="number"
              :value="old('participants_count', $campaign->participants_count ?? '')" />

<x-form.textarea name="description" label='<i class="fas fa-align-right text-muted ms-1"></i> الوصف'>
    {{ old('description',$campaign->description??'') }}
</x-form.textarea>

<x-form.select name="planned" label='<i class="fas fa-check text-muted ms-1"></i> مخطط لها؟'>
    <option value="0" @selected(old('planned', $campaign->planned ?? 0) == 0)>لا</option>
    <option value="1" @selected(old('planned', $campaign->planned ?? 0) == 1)>نعم</option>
</x-form.select>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
