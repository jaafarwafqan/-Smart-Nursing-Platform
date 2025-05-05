@props(['research' => null, 'branches'])

@php  $isEdit = ! is_null($research); @endphp

<x-form.select name="branch_id" label='<i class="fas fa-code-branch text-muted ms-1"></i> الفرع'>
    @foreach($branches as $id => $name)
        <option value="{{ $id }}" @selected(old('branch_id', $research->branch_id ?? '') == $id)>
            {{ $name }}
        </option>
    @endforeach
</x-form.select>

<x-form.input name="research_title" label='<i class="fas fa-heading text-muted ms-1"></i> عنوان البحث' :value="old('research_title', $research->research_title ?? $research->title ?? '')" />

<x-form.input name="research_type" label='<i class="fas fa-list text-muted ms-1"></i> نوع البحث'
              :value="old('research_type', $research->research_type ?? '')" />

<x-form.input type="date" name="start_date" label='<i class="fas fa-calendar-plus text-muted ms-1"></i> تاريخ البدء'
              :value="old('start_date', $research->start_date ?? '')" />

<x-form.input type="date" name="end_date" label='<i class="fas fa-calendar-check text-muted ms-1"></i> تاريخ الانتهاء'
              :value="old('end_date', $research->end_date ?? '')" />

<x-form.input name="status" label='<i class="fas fa-flag-checkered text-muted ms-1"></i> الحالة (جاري/مكتمل/موقوف)'
              :value="old('status', $research->status ?? '')" />

<x-form.textarea name="description" label='<i class="fas fa-align-right text-muted ms-1"></i> الوصف'>
    {{ old('description', $research->description ?? '') }}
</x-form.textarea>

<x-form.input type="file" name="file" label='<i class="fas fa-file-alt text-muted ms-1"></i> ملف البحث' class="form-control"/>

<x-form.textarea name="abstract" label='<i class="fas fa-align-left text-muted ms-1"></i> ملخص البحث'>
    {{ old('abstract', $research->abstract ?? '') }}
</x-form.textarea>

<x-form.input name="keywords" label='<i class="fas fa-key text-muted ms-1"></i> الكلمات المفتاحية' :value="old('keywords', $research->keywords ?? '')" />
<small class="text-muted">افصل بين الكلمات بفاصلة</small>

<x-form.textarea name="notes" label='<i class="fas fa-sticky-note text-muted ms-1"></i> ملاحظات'>
    {{ old('notes', $research->notes ?? '') }}
</x-form.textarea>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user-graduate text-muted ms-1"></i> الطلاب</label>
            <div id="students-container">
                @if(isset($students) && isset($selectedStudents))
                    @foreach($selectedStudents as $student)
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <select class="form-select" name="students[]" required>
                                    <option value="">اختر طالب</option>
                                    @foreach($students as $s)
                                        <option value="{{ $s->id }}" {{ $s->id == $student->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="student_roles[]" required>
                                    <option value="author" {{ $student->pivot->role == 'author' ? 'selected' : '' }}>مؤلف</option>
                                    <option value="co-author" {{ $student->pivot->role == 'co-author' ? 'selected' : '' }}>مؤلف مشارك</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <select class="form-select" name="students[]" required>
                                <option value="">اختر طالب</option>
                                @if(isset($students))
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="student_roles[]" required>
                                <option value="author">مؤلف</option>
                                <option value="co-author">مؤلف مشارك</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addStudentField()">
                <i class="fas fa-plus"></i> إضافة طالب
            </button>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-chalkboard-teacher text-muted ms-1"></i> الأساتذة</label>
            <div id="professors-container">
                @if(isset($professors) && isset($selectedProfessors))
                    @foreach($selectedProfessors as $professor)
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <select class="form-select" name="professors[]" required>
                                    <option value="">اختر أستاذ</option>
                                    @foreach($professors as $p)
                                        <option value="{{ $p->id }}" {{ $p->id == $professor->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" name="professor_roles[]" required>
                                    <option value="supervisor" {{ $professor->pivot->role == 'supervisor' ? 'selected' : '' }}>مشرف</option>
                                    <option value="reviewer" {{ $professor->pivot->role == 'reviewer' ? 'selected' : '' }}>مراجع</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <select class="form-select" name="professors[]" required>
                                <option value="">اختر أستاذ</option>
                                @if(isset($professors))
                                    @foreach($professors as $professor)
                                        <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="professor_roles[]" required>
                                <option value="supervisor">مشرف</option>
                                <option value="reviewer">مراجع</option>
                            </select>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addProfessorField()">
                <i class="fas fa-plus"></i> إضافة أستاذ
            </button>
        </div>
    </div>
</div>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>
