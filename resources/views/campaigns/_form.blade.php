@props(['campaign'=>null,'branches'])
@php $isEdit=!is_null($campaign); @endphp

<x-form.select name="branch_id" label="الفرع">
    @foreach($branches as $id=>$name)
        <option value="{{ $id }}" @selected(old('branch_id',$campaign->branch_id??'')==$id)>{{ $name }}</option>
    @endforeach
</x-form.select>

<x-form.input name="campaign_title" label="عنوان الحملة"
              :value="old('campaign_title',$campaign->campaign_title??'')" />

<x-form.input name="campaign_type" label="نوع الحملة"
              :value="old('campaign_type',$campaign->campaign_type??'')" />

<x-form.input type="datetime-local" name="campaign_datetime" label="التاريخ والوقت"
              :value="old('campaign_datetime',optional($campaign?->campaign_datetime)->format('Y-m-d\TH:i'))" />

<x-form.input name="location" label="الموقع"
              :value="old('location',$campaign->location??'')" />

<x-form.input name="audience" label="الجمهور المستهدف" type="number"
              :value="old('audience',$campaign->audience??'')" />

<x-form.textarea name="description" label="الوصف">
    {{ old('description',$campaign->description??'') }}
</x-form.textarea>

<x-form.input type="file" name="attachments[]" label="مرفقات" multiple class="form-control"/>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
