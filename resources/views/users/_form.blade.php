@php
    /** @var \App\Models\User|null $user */
    $isEdit = isset($user);
@endphp

{{-- رسائل الخطأ --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>تنبيه!</strong> يرجى تصحيح الحقول التالية:
        <ul class="mb-0 mt-1 small">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    {{-- الاسم --}}
    <x-form.input name="name" label="الاسم" :value="old('name', $user->name ?? '')" class="col-md-6" />

    {{-- البريد --}}
    <x-form.input type="email" name="email" label="البريد الإلكتروني"
                  :value="old('email', $user->email ?? '')" class="col-md-6" />

    {{-- كلمة المرور (اختياري في التعديل) --}}
    <x-form.input type="password" name="password" label="كلمة المرور"
                  :required="!$isEdit" class="col-md-6" />

    <x-form.input type="password" name="password_confirmation" label="تأكيد كلمة المرور"
                  :required="!$isEdit" class="col-md-6" />

    {{-- النوع --}}
    <x-form.select name="type" label="نوع المستخدم" class="col-md-4">
        @foreach($types as $k=>$v)
            <option value="{{ $k }}" @selected(old('type', $user->type ?? '') == $k)>{{ $v }}</option>
        @endforeach
    </x-form.select>

    {{-- الفرع --}}
    <x-form.select name="branch_id" label="الفرع" class="col-md-4">
        <option value="">—</option>
        @foreach($branches as $id=>$name)
            <option value="{{ $id }}" @selected(old('branch_id', $user->branch_id ?? '') == $id)>{{ $name }}</option>
        @endforeach
    </x-form.select>

    {{-- الأدوار (Spatie) --}}
    <select name="roles[]" class="form-select select-roles" multiple>
        @foreach($roles as $role)
            <option value="{{ $role }}"
                @selected(collect(old('roles',$user?->roles->pluck('name') ?? []))->contains($role))>
                {{ $role }}
            </option>
        @endforeach
    </select>


</div>

{{-- زر الحفظ --}}
<div class="mt-4">
    <x-button.primary><i class="fas fa-save"></i> {{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">رجوع</a>
</div>
