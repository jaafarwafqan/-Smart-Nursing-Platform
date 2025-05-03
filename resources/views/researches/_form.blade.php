@props(['research' => null, 'branches'])

@php  $isEdit = ! is_null($research); @endphp

<x-form.select name="branch_id" label="الفرع">
    @foreach($branches as $id => $name)
        <option value="{{ $id }}" @selected(old('branch_id', $research->branch_id ?? '') == $id)>
            {{ $name }}
        </option>
    @endforeach
</x-form.select>

<x-form.input name="research_title" label="عنوان البحث"
              :value="old('research_title', $research->research_title ?? '')" />

<x-form.input name="research_type" label="نوع البحث"
              :value="old('research_type', $research->research_type ?? '')" />

<x-form.input type="date" name="start_date" label="تاريخ البدء"
              :value="old('start_date', $research->start_date ?? '')" />

<x-form.input type="date" name="end_date" label="تاريخ الانتهاء"
              :value="old('end_date', $research->end_date ?? '')" />

<x-form.input name="status" label="الحالة (جاري/مكتمل/موقوف)"
              :value="old('status', $research->status ?? '')" />

<x-form.textarea name="description" label="الوصف">
    {{ old('description', $research->description ?? '') }}
</x-form.textarea>

<x-form.input type="file" name="attachments[]" label="مرفقات" multiple class="form-control"/>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
