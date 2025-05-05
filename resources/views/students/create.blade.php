@extends('layouts.app')
@section('title','إضافة طالب جديد')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">إضافة طالب جديد</h2>
        <form method="POST" action="{{ route('students.store') }}">
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
                        <option value="انثى" @selected(old('gender')=='انثى')>انثى</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الميلاد</label>
                    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">الرقم الجامعي</label>
                    <input type="text" name="university_number" class="form-control" value="{{ old('university_number') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">نوع الدراسة</label>
                    <select name="study_type" class="form-select" required id="study_type_select">
                        <option value="">اختر</option>
                        <option value="أولية" @selected(old('study_type')=='أولية')>أولية</option>
                        <option value="ماجستير" @selected(old('study_type')=='ماجستير')>ماجستير</option>
                        <option value="دكتوراه" @selected(old('study_type')=='دكتوراه')>دكتوراه</option>
                    </select>
                </div>
                <div class="col-md-4" id="study_year_field" style="display:none;">
                    <label class="form-label">سنة الدراسة (للأولية)</label>
                    <input type="number" name="study_year" class="form-control" value="{{ old('study_year') }}">
                </div>
                <div class="col-md-4" id="program_field" style="display:none;">
                    <label class="form-label">البرنامج (للدراسات العليا)</label>
                    <input type="text" name="program" class="form-control" value="{{ old('program') }}">
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
