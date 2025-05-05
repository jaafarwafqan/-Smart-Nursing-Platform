@extends('layouts.app')
@section('title','إضافة أستاذ جديد')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">إضافة أستاذ جديد</h2>
    <form method="POST" action="{{ route('professors.store') }}">
        @csrf
        @include('professors._form', ['professor' => null])
        <div class="mt-4">
            <button class="btn btn-success">حفظ</button>
            <a href="{{ route('professors.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection 