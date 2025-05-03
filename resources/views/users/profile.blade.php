@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">تعديل المعلومات الشخصية</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- نموذج تعديل المعلومات الشخصية -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-3">تعديل المعلومات</h4>
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">الاسم</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name', auth()->user()->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', auth()->user()->email) }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> حفظ التعديلات
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- نموذج تغيير كلمة المرور -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3">تغيير كلمة المرور</h4>
                        <form action="{{ route('profile.changePassword') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">كلمة المرور الحالية</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">تأكيد كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> تحديث كلمة المرور
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
