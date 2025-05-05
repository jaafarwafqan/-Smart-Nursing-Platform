@extends('layouts.app')
@section('title','تعديل بيانات الأستاذ')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">تعديل بيانات الأستاذ</h2>
    <form method="POST" action="{{ route('professors.update', $professor) }}">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $professor->name) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">الجنس</label>
                <select name="gender" class="form-select" required>
                    <option value="">اختر</option>
                    <option value="ذكر" @selected(old('gender', $professor->gender)=='ذكر')>ذكر</option>
                    <option value="أنثى" @selected(old('gender', $professor->gender)=='أنثى')>أنثى</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">الرتبة العلمية</label>
                <select name="academic_rank" class="form-select" required>
                    <option value="">اختر</option>
                    <option value="مدرس" @selected(old('academic_rank', $professor->academic_rank)=='مدرس')>مدرس</option>
                    <option value="مدرس مساعد" @selected(old('academic_rank', $professor->academic_rank)=='مدرس مساعد')>مدرس مساعد</option>
                    <option value="أستاذ" @selected(old('academic_rank', $professor->academic_rank)=='أستاذ')>أستاذ</option>
                    <option value="أستاذ مساعد" @selected(old('academic_rank', $professor->academic_rank)=='أستاذ مساعد')>أستاذ مساعد</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الكلية</label>
                <input type="text" name="college" class="form-control" value="{{ old('college', $professor->college) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">القسم</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $professor->department) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">مجالات الاهتمام البحثي</label>
                <input type="text" name="research_interests" class="form-control" value="{{ old('research_interests', $professor->research_interests) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $professor->phone) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $professor->email) }}">
            </div>
            <div class="col-md-12">
                <label class="form-label">ملاحظات</label>
                <textarea name="notes" class="form-control">{{ old('notes', $professor->notes) }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn btn-success">حفظ التعديلات</button>
            <a href="{{ route('professors.index') }}" class="btn btn-secondary">إلغاء</a>
        </div>
    </form>
</div>
@endsection 