@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إضافة مستخدم جديد</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        @include('users._form', [
                            'branches' => $branches,
                            'roles' => $roles,
                            'permissions' => $permissions
                        ])
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">حفظ</button>
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
