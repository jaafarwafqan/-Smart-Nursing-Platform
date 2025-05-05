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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label"><i class="fas fa-user text-muted ms-1"></i> الاسم الكامل</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope text-muted ms-1"></i> البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label"><i class="fas fa-key text-muted ms-1"></i> كلمة المرور</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label"><i class="fas fa-key text-muted ms-1"></i> تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label"><i class="fas fa-user-tag text-muted ms-1"></i> نوع المستخدم</label>
                            <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">اختر النوع</option>
                                @foreach($types as $value => $label)
                                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="branch_id" class="form-label"><i class="fas fa-code-branch text-muted ms-1"></i> الفرع</label>
                            <select name="branch_id" id="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                                <option value="">اختر الفرع</option>
                                @foreach($branches as $id => $name)
                                    <option value="{{ $id }}" {{ old('branch_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="roles" class="form-label"><i class="fas fa-user-shield text-muted ms-1"></i> الأدوار</label>
                            <select name="roles[]" id="roles" class="form-select @error('roles') is-invalid @enderror" multiple>
                                @foreach($roles as $id => $name)
                                    <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="avatar" class="form-label"><i class="fas fa-image text-muted ms-1"></i> الصورة الشخصية</label>
                            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
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
