@extends('layouts.app')
@section('title','استيراد الأساتذة من Excel')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">استيراد الأساتذة من ملف Excel</h2>
    <div class="alert alert-info">
        <strong>تنسيق الملف المطلوب:</strong><br>
        يجب أن يحتوي ملف Excel على الأعمدة التالية:<br>
        <ul>
            <li><strong>name</strong> (اسم الأستاذ) <span class="text-danger">إجباري</span></li>
            <li><strong>gender</strong> (الجنس: ذكر/أنثى) <span class="text-danger">إجباري</span></li>
            <li>academic_rank (الرتبة العلمية) <span class="text-muted">اختياري</span></li>
            <li>college (الكلية) <span class="text-muted">اختياري</span></li>
            <li>department (القسم) <span class="text-muted">اختياري</span></li>
            <li>research_interests (مجالات الاهتمام البحثي) <span class="text-muted">اختياري</span></li>
            <li>phone (الهاتف) <span class="text-muted">اختياري</span></li>
            <li>email (البريد الإلكتروني) <span class="text-muted">اختياري</span></li>
            <li>notes (ملاحظات) <span class="text-muted">اختياري</span></li>
        </ul>
        <a href="{{ asset('templates/professors_template.xlsx') }}" class="btn btn-outline-primary btn-sm mt-2">تحميل قالب Excel فارغ</a>
    </div>
    <form method="POST" action="{{ route('professors.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">اختر ملف Excel</label>
            <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
        </div>
        <button class="btn btn-success">استيراد</button>
        <a href="{{ route('professors.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection 