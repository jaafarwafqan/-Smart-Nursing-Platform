@extends('layouts.app')
@section('title', 'تعديل مستخدم')

@section('content')
    <div class="container py-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">تعديل مستخدم</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('users._form', [
                        'types' => $types,
                        'branches' => $branches,
                        'roles' => $roles,
                        'rolesData' => $rolesData,
                        'user' => $user
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
    </script>
@endpush
