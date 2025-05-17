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

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name ?? null) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email ?? null) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">{{ isset($user) ? 'كلمة المرور الجديدة (اختياري)' : 'كلمة المرور' }}</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">تأكيد كلمة المرور{{ isset($user) ? ' الجديدة' : '' }}</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="type">نوع المستخدم</label>
            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                <option value="">اختر نوع المستخدم</option>
                <x-user-type-gate types="admin">
                    <option value="admin" {{ old('type', $user->type ?? null) === 'admin' ? 'selected' : '' }}>مدير</option>
                </x-user-type-gate>
                <option value="supervisor" {{ old('type', $user->type ?? null) === 'supervisor' ? 'selected' : '' }}>مشرف</option>
                <option value="user" {{ old('type', $user->type ?? null) === 'user' ? 'selected' : '' }}>مستخدم</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="branch_id">الفرع</label>
            <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                <option value="">اختر الفرع</option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id ?? null) == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
            @error('branch_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="roles">الأدوار</label>
            <select class="form-control select2 @error('roles') is-invalid @enderror" id="roles" name="roles[]" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', isset($user) ? $user->roles->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="permissions">الصلاحيات</label>
            <select class="form-control select2 @error('permissions') is-invalid @enderror" id="permissions" name="permissions[]" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions', isset($user) ? $user->permissions->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                        {{ $permission->name }}
                    </option>
                @endforeach
            </select>
            @error('permissions')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
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
