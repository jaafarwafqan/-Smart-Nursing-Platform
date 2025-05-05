@extends('layouts.app')
@section('title','استيراد الطلاب من Excel')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">استيراد الطلاب من ملف Excel</h2>
    <div class="alert alert-info">
        <strong>تنسيق الملف المطلوب:</strong><br>
        يجب أن يحتوي ملف Excel على الأعمدة التالية:<br>
        <ul>
            <li><strong>name</strong> (اسم الطالب) <span class="text-danger">إجباري</span></li>
            <li><strong>gender</strong> (الجنس: ذكر/انثى) <span class="text-danger">إجباري</span></li>
            <li><strong>study_type</strong> (نوع الدراسة: أولية/ماجستير/دكتوراه) <span class="text-danger">إجباري</span></li>
            <li>birthdate (تاريخ الميلاد: yyyy-mm-dd) <span class="text-muted">اختياري</span></li>
            <li>university_number (الرقم الجامعي) <span class="text-muted">اختياري</span></li>
            <li>study_year (سنة الدراسة - للأولية فقط) <span class="text-muted">اختياري</span></li>
            <li>program (البرنامج - للدراسات العليا فقط) <span class="text-muted">اختياري</span></li>
            <li>phone (الهاتف) <span class="text-muted">اختياري</span></li>
            <li>email (البريد الإلكتروني) <span class="text-muted">اختياري</span></li>
            <li>notes (ملاحظات) <span class="text-muted">اختياري</span></li>
        </ul>
        <a href="{{ asset('templates/students_template.xlsx') }}" class="btn btn-outline-primary btn-sm mt-2">تحميل قالب Excel فارغ</a>
    </div>
    <form method="POST" action="{{ route('students.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">اختر ملف Excel</label>
            <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
        </div>
        <button class="btn btn-success">استيراد</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
