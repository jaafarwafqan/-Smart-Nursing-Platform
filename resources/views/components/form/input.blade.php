@props(['label','name','type'=>'text'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold">{{ $label }}</label>
    <input {{ $attributes->merge([
            'class'=>'form-control '.($errors->has($name)?'is-invalid':''),
            'id'=>$name,
            'name'=>$name,
            'type'=>$type
        ]) }}>
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
