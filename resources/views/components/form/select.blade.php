@props(['label','name'])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold">{{ $label }}</label>
    <select {{ $attributes->merge([
            'class'=>'form-select '.($errors->has($name)?'is-invalid':''),
            'id'=>$name,
            'name'=>$name
        ]) }}>
        {{ $slot }}
    </select>
    @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
