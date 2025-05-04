@extends('layouts.app')
@section('title','تعديل بحث')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">تعديل البحث</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('researches.update', $research) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">عنوان البحث</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $research->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file" class="form-label">ملف البحث</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                           id="file" name="file" accept=".pdf,.doc,.docx">
                                    @if($research->file_path)
                                        <small class="text-muted">الملف الحالي: 
                                            <a href="{{ route('researches.download', $research) }}">
                                                تحميل الملف
                                            </a>
                                        </small>
                                    @endif
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="abstract" class="form-label">ملخص البحث</label>
                            <textarea class="form-control @error('abstract') is-invalid @enderror" 
                                      id="abstract" name="abstract" rows="3">{{ old('abstract', $research->abstract) }}</textarea>
                            @error('abstract')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keywords" class="form-label">الكلمات المفتاحية</label>
                            <input type="text" class="form-control @error('keywords') is-invalid @enderror" 
                                   id="keywords" name="keywords" value="{{ old('keywords', $research->keywords) }}">
                            <small class="text-muted">افصل بين الكلمات بفاصلة</small>
                            @error('keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">ملاحظات</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="2">{{ old('notes', $research->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">الطلاب</label>
                                    <div id="students-container">
                                        @foreach($research->students as $student)
                                            <div class="row mb-2">
                                                <div class="col-md-8">
                                                    <select class="form-select" name="students[]" required>
                                                        <option value="">اختر طالب</option>
                                                        @foreach($students as $s)
                                                            <option value="{{ $s->id }}" 
                                                                {{ $s->id == $student->id ? 'selected' : '' }}>
                                                                {{ $s->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select" name="student_roles[]" required>
                                                        <option value="author" {{ $student->pivot->role == 'author' ? 'selected' : '' }}>
                                                            مؤلف
                                                        </option>
                                                        <option value="co-author" {{ $student->pivot->role == 'co-author' ? 'selected' : '' }}>
                                                            مؤلف مشارك
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="addStudentField()">
                                        <i class="fas fa-plus"></i> إضافة طالب
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">الأساتذة</label>
                                    <div id="professors-container">
                                        @foreach($research->professors as $professor)
                                            <div class="row mb-2">
                                                <div class="col-md-8">
                                                    <select class="form-select" name="professors[]" required>
                                                        <option value="">اختر أستاذ</option>
                                                        @foreach($professors as $p)
                                                            <option value="{{ $p->id }}" 
                                                                {{ $p->id == $professor->id ? 'selected' : '' }}>
                                                                {{ $p->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="form-select" name="professor_roles[]" required>
                                                        <option value="supervisor" {{ $professor->pivot->role == 'supervisor' ? 'selected' : '' }}>
                                                            مشرف
                                                        </option>
                                                        <option value="reviewer" {{ $professor->pivot->role == 'reviewer' ? 'selected' : '' }}>
                                                            مراجع
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-sm btn-secondary" onclick="addProfessorField()">
                                        <i class="fas fa-plus"></i> إضافة أستاذ
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('researches.show', $research) }}" class="btn btn-secondary me-2">إلغاء</a>
                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addStudentField() {
    const container = document.getElementById('students-container');
    const newField = document.createElement('div');
    newField.className = 'row mb-2';
    newField.innerHTML = `
        <div class="col-md-8">
            <select class="form-select" name="students[]" required>
                <option value="">اختر طالب</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="student_roles[]" required>
                <option value="author">مؤلف</option>
                <option value="co-author">مؤلف مشارك</option>
            </select>
        </div>
    `;
    container.appendChild(newField);
}

function addProfessorField() {
    const container = document.getElementById('professors-container');
    const newField = document.createElement('div');
    newField.className = 'row mb-2';
    newField.innerHTML = `
        <div class="col-md-8">
            <select class="form-select" name="professors[]" required>
                <option value="">اختر أستاذ</option>
                @foreach($professors as $professor)
                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-select" name="professor_roles[]" required>
                <option value="supervisor">مشرف</option>
                <option value="reviewer">مراجع</option>
            </select>
        </div>
    `;
    container.appendChild(newField);
}
</script>
@endpush
@endsection
