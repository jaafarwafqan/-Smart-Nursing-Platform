@extends('layouts.app')
@section('title','تعديل مستخدم')

@section('content')
    <div class="container py-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h5 class="mb-0">تعديل مستخدم</h5></div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    @include('users._form', ['user'=>$user, 'types'=>$types, 'branches'=>$branches, 'roles'=>$roles])
                </form>
            </div>
        </div>
    </div>
@endsection
