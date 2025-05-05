@props(['campaign'=>null,'branches'])
@php $isEdit=!is_null($campaign); @endphp


<x-form.select name="branch_id" label='<i class="fas fa-code-branch text-muted ms-1"></i> الفرع'>
    @foreach($branches as $id => $name)
        <option value="{{ $id }}" @selected(old('branch_id', $event->branch_id ?? '')==$id)>{{ $name }}</option>
    @endforeach
</x-form.select>

<x-form.input name="campaign_title" label='<i class="fas fa-heading text-muted ms-1"></i> عنوان الحملة'
              :value="old('campaign_title',$campaign->campaign_title??'')" />

<x-form.input name="campaign_type" label='<i class="fas fa-list text-muted ms-1"></i> نوع الحملة'
              :value="old('campaign_type',$campaign->campaign_type??'')" />

<x-form.input type="datetime-local" name="campaign_datetime" label='<i class="fas fa-calendar-alt text-muted ms-1"></i> التاريخ والوقت'
              :value="old('campaign_datetime',optional($campaign?->campaign_datetime)->format('Y-m-d\\TH:i'))" />

<x-form.input name="location" label='<i class="fas fa-map-marker-alt text-muted ms-1"></i> الموقع'
              :value="old('location',$campaign->location??'')" />

<x-form.input name="audience" label='<i class="fas fa-users text-muted ms-1"></i> الجمهور المستهدف' type="number"
              :value="old('audience',$campaign->audience??'')" />

<x-form.textarea name="description" label='<i class="fas fa-align-right text-muted ms-1"></i> الوصف'>
    {{ old('description',$campaign->description??'') }}
</x-form.textarea>

<x-form.input type="file" name="attachments[]" label='<i class="fas fa-paperclip text-muted ms-1"></i> مرفقات' multiple class="form-control"/>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
