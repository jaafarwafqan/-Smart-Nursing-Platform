@props(['event' => null, 'branches'])

@php
    $isEdit = ! is_null($event);
@endphp


<x-form.select name="branch_id" label='<i class="fas fa-code-branch text-muted ms-1"></i> الفرع'>
    @foreach($branches as $id => $name)
        <option value="{{ $id }}" @selected(old('branch_id', $event->branch_id ?? '')==$id)>{{ $name }}</option>
    @endforeach
</x-form.select>


<x-form.input name="event_title" label='<i class="fas fa-heading text-muted ms-1"></i> عنوان الفعالية'
              :value="old('event_title', $event->event_title ?? '')" />

<x-form.select  name="event_type"   label='<i class="fas fa-list text-muted ms-1"></i> نوع الفعالية'>
    @foreach($eventTypes as $type)
        <option value="{{ $type }}"
            @selected(old('event_type', $event->event_type ?? '') === $type)>
            {{ $type }}
        </option>
    @endforeach
</x-form.select>

<x-form.input type="datetime-local" name="event_datetime" label='<i class="fas fa-calendar-alt text-muted ms-1"></i> التاريخ والوقت'
              :value="old('event_datetime', optional($event?->event_datetime)->format('Y-m-d\\TH:i'))" />

<x-form.input name="location" label='<i class="fas fa-map-marker-alt text-muted ms-1"></i> الموقع'
              :value="old('location', $event->location ?? '')" />

<x-form.textarea name="description" label='<i class="fas fa-align-right text-muted ms-1"></i> الوصف'>
    {{ old('description', $event->description ?? '') }}
</x-form.textarea>

<x-form.input type="file" name="attachments[]" label='<i class="fas fa-paperclip text-muted ms-1"></i> مرفقات' multiple
              class="form-control"/>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
