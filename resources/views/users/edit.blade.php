@extends('layouts.app')

@section('title', 'تعديل المستخدم')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تعديل المستخدم</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('users._form', [
                            'user' => $user,
                            'branches' => $branches,
                            'roles' => $roles,
                            'permissions' => $permissions
                        ])
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    });
</script>
@endpush
