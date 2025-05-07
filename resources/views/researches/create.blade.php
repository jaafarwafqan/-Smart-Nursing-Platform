@extends('layouts.app')
@section('title','إضافة بحث')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">إضافة بحث جديد</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('researches.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('researches._form', [
                            'research' => null,
                            'branches' => $branches ?? [],
                            'students' => $students ?? [],
                            'professors' => $professors ?? [],
                            'journals' => $journals ?? [],
                            'selectedStudents' => [],
                            'selectedProfessors' => [],
                        ])
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
