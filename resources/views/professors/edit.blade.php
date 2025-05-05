@extends('layouts.app')
@section('title','تعديل بيانات الأستاذ')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">تعديل بيانات الأستاذ</h2>
    <form method="POST" action="{{ route('professors.update', $professor) }}">
        @csrf
        @method('PUT')
        @include('professors._form', ['professor' => $professor])
        <div class="mt-4">
            <button class="btn btn-success">حفظ التعديلات</button>
            <a href="{{ route('professors.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection 