@extends('layouts.app')
@section('title','تعديل بيانات الطالب')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">تعديل بيانات الطالب</h2>
    <form method="POST" action="{{ route('students.update', $student) }}">
        @csrf
        @method('PUT')
        @include('students._form', ['student' => $student])
        <div class="mt-4">
            <button class="btn btn-success">حفظ التعديلات</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
<script>
    function toggleFields() {
        var type = document.getElementById('study_type_select').value;
        document.getElementById('study_year_field').style.display = (type === 'أولية') ? '' : 'none';
        document.getElementById('program_field').style.display = (type === 'ماجستير' || type === 'دكتوراه') ? '' : 'none';
    }
    document.getElementById('study_type_select').addEventListener('change', toggleFields);
    window.onload = toggleFields;
</script>
@endsection
