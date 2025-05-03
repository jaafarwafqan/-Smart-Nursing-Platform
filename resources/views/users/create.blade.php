@extends('layouts.app')
@section('title','إضافة مستخدم')

@section('content')
    <div class="container py-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h5 class="mb-0">إضافة مستخدم</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    @include('users._form', ['user'=>null, 'types'=>$types, 'branches'=>$branches, 'roles'=>$roles])
                </form>
            </div>
        </div>
    </div>
@endsection
