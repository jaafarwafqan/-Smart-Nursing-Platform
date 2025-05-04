@extends('layouts.app')
@section('title','إضافة أستاذ جديد')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">إضافة أستاذ جديد</h2>
    <form method="POST" action="{{ route('professors.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">الجنس</label>
                <select name="gender" class="form-select" required>
                    <option value="">اختر</option>
                    <option value="ذكر" @selected(old('gender')=='ذكر')>ذكر</option>
                    <option value="أنثى" @selected(old('gender')=='أنثى')>أنثى</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">الرتبة العلمية</label>
                <input type="text" name="academic_rank" class="form-control" value="{{ old('academic_rank') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الكلية</label>
                <input type="text" name="college" class="form-control" value="{{ old('college') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم</label>
                <input type="text" name="department" class="form-control" value="{{ old('department') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">مجالات الاهتمام البحثي</label>
                <input type="text" name="research_interests" class="form-control" value="{{ old('research_interests') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="col-md-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-success">حفظ</button>
            <a href="{{ route('professors.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection 