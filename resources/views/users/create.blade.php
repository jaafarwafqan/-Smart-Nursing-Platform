@extends('layouts.app')
@section('title', 'إضافة مستخدم')

@section('content')
    <div class="container py-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">إضافة مستخدم جديد</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('users._form', [
                        'types' => $types,
                        'branches' => $branches,
                        'roles' => $roles,
                        'rolesData' => $rolesData,
                        'user' => null
                    ])
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize select2 for roles
        $(document).ready(function() {
            $('#roles').select2({
                placeholder: 'اختر الأدوار',
                allowClear: true
            });
        });

        // بيانات الأدوار مع الصلاحيات من السيرفر
        const rolesData = @json($rolesData);
        // ترجمة الصلاحيات من السيرفر (نفس دالة الهيلبر)
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
