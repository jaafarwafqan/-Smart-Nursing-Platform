@props(['student' => null, 'branches', 'selectedStudents' => []])
@php $isEdit = !is_null($student); @endphp

<div class="row g-3">
    <div class="col-md-6">
        <x-form.input name="name" label='<i class="fas fa-user text-muted ms-1"></i> الاسم' :value="old('name', $student->name ?? '')" required />
    </div>
    <div class="col-md-3">
        <x-form.select name="gender" label='<i class="fas fa-venus-mars text-muted ms-1"></i> الجنس' required>
            <option value="">اختر</option>
            <option value="ذكر" @selected(old('gender', $student->gender ?? '')=='ذكر')>ذكر</option>
            <option value="انثى" @selected(old('gender', $student->gender ?? '')=='انثى')>أنثى</option>
        </x-form.select>
    </div>
    <div class="col-md-3">
        <x-form.input type="date" name="birthdate" label='<i class="fas fa-calendar-alt text-muted ms-1"></i> تاريخ الميلاد' :value="old('birthdate', $student->birthdate ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input name="university_number" label='<i class="fas fa-id-card text-muted ms-1"></i> الرقم الجامعي' :value="old('university_number', $student->university_number ?? '')" required />
    </div>
    <div class="col-md-4">
        <x-form.select name="study_type" label='<i class="fas fa-graduation-cap text-muted ms-1"></i> نوع الدراسة' required id="study_type_select">
            <option value="">اختر</option>
            <option value="أولية" @selected(old('study_type', $student->study_type ?? '')=='أولية')>أولية</option>
            <option value="ماجستير" @selected(old('study_type', $student->study_type ?? '')=='ماجستير')>ماجستير</option>
            <option value="دكتوراه" @selected(old('study_type', $student->study_type ?? '')=='دكتوراه')>دكتوراه</option>
        </x-form.select>
    </div>
    <div class="col-md-4" id="study_year_field" style="display:none;">
        <x-form.input type="number" name="study_year" label='<i class="fas fa-calendar text-muted ms-1"></i> سنة الدراسة (للأولية)' :value="old('study_year', $student->study_year ?? '')" />
    </div>
    <div class="col-md-4" id="program_field" style="display:none;">
        <x-form.input name="program" label='<i class="fas fa-book text-muted ms-1"></i> البرنامج (للدراسات العليا)' :value="old('program', $student->program ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input name="phone" label='<i class="fas fa-phone text-muted ms-1"></i> الهاتف' :value="old('phone', $student->phone ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input type="email" name="email" label='<i class="fas fa-envelope text-muted ms-1"></i> البريد الإلكتروني' :value="old('email', $student->email ?? '')" />
    </div>
    <div class="col-md-12">
        <x-form.textarea name="notes" label='<i class="fas fa-sticky-note text-muted ms-1"></i> ملاحظات'>{{ old('notes', $student->notes ?? '') }}</x-form.textarea>
    </div>
</div>

@push('scripts')
<script>
function toggleFields() {
    var type = document.getElementById('study_type_select').value;
    document.getElementById('study_year_field').style.display = (type === 'أولية') ? '' : 'none';
    document.getElementById('program_field').style.display = (type === 'ماجستير' || type === 'دكتوراه') ? '' : 'none';
}
document.getElementById('study_type_select').addEventListener('change', toggleFields);
window.onload = toggleFields;
</script>
@endpush

