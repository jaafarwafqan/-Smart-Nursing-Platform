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
    <select name="roles[]" id="roles" class="form-select select-roles" multiple>
        @foreach($roles as $id => $name)
            <option value="{{ $id }}"
                @selected(collect(old('roles',$user?->roles->pluck('id') ?? []))->contains($id))>
                {{ $name }}
            </option>
        @endforeach
    </select>

    <!-- عرض الصلاحيات المرتبطة بالأدوار المختارة -->
    <div class="col-12 mb-3">
        <div id="role-permissions" class="alert alert-info" style="display:none;"></div>
    </div>

</div>

{{-- زر الحفظ --}}
<div class="mt-4">
    <x-button.primary><i class="fas fa-save"></i> {{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">رجوع</a>
</div>

@push('scripts')
<script>
    // بيانات الأدوار مع الصلاحيات من السيرفر (يجب تمريرها من الكنترولر)
    const rolesData = @json($rolesData ?? []);
    // ترجمة الصلاحيات
    const permTrans = {
        'manage_campaigns': 'إدارة الحملات',
        'manage_events': 'إدارة الفعاليات',
        'manage_researches': 'إدارة الأبحاث',
        'manage_proposals': 'إدارة المقترحات',
        'manage_users': 'إدارة المستخدمين',
        'manage_reports': 'إدارة التقارير',
        'system_admin': 'مدير النظام',
    };
    function translatePermission(perm) {
        return permTrans[perm] ?? perm;
    }
    function updatePermissions() {
        let selected = Array.from(document.getElementById('roles').selectedOptions).map(opt => opt.value);
        let html = '';
        if (selected.length === 0) {
            html = '<span class="text-muted">يرجى اختيار دور لعرض الصلاحيات المرتبطة به.</span>';
        } else {
            rolesData.forEach(role => {
                if (selected.includes(role.id.toString())) {
                    html += `<div class='mb-2'><strong><i class='fas fa-user-shield text-primary'></i> ${role.name}:</strong><ul style='margin-bottom:0;'>`;
                    if (role.permissions.length === 0) {
                        html += '<li><em>لا توجد صلاحيات</em></li>';
                    } else {
                        role.permissions.forEach(perm => {
                            html += `<li><i class='fas fa-check-circle text-success'></i> ${translatePermission(perm.name)}</li>`;
                        });
                    }
                    html += '</ul></div>';
                }
            });
        }
        const box = document.getElementById('role-permissions');
        if (html) {
            box.innerHTML = html;
            box.style.display = 'block';
        } else {
            box.innerHTML = '';
            box.style.display = 'none';
        }
    }
    document.getElementById('roles').addEventListener('change', updatePermissions);
    document.addEventListener('DOMContentLoaded', updatePermissions);
</script>
@endpush
