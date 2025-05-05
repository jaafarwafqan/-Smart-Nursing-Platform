@props(['label','name','rows'=>3])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold">{!! $label !!}</label>
    <textarea {{ $attributes->merge([
            'class'=>'form-control '.($errors->has($name)?'is-invalid':''),
            'id'=>$name,
            'name'=>$name,
            'rows'=>$rows
        ]) }}>{{ $slot ?? old($name) }}</textarea>
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
