@props(['research' => null, 'branches', 'journals' => []])

@php  $isEdit = ! is_null($research); @endphp

@php
    $journalTypeText = [
        'local' => 'محلي',
        'international' => 'عالمي',
        'scopus' => 'عالمي ضمن مستوعبات اسكوبس',
        'clarivate' => 'عالمي ضمن مستوعبات كلاريفيت',
    ];
@endphp

<x-form.select name="branch_id" label='<i class="fas fa-code-branch text-muted ms-1"></i> الفرع'>
    @foreach($branches as $id => $name)
        <option value="{{ $id }}" @selected(old('branch_id', $research->branch_id ?? '') == $id)>
            {{ $name }}
        </option>
    @endforeach
</x-form.select>

<x-form.input name="title" label='<i class="fas fa-heading text-muted ms-1"></i> عنوان البحث' :value="old('title', $research->title ?? '')" />

<x-form.select name="research_type" label='<i class="fas fa-list text-muted ms-1"></i> نوع البحث'>
    <option value="qualitative" @selected(old('research_type', $research->research_type ?? '') == 'qualitative')>نوعي</option>
    <option value="quantitative" @selected(old('research_type', $research->research_type ?? '') == 'quantitative')>كمي</option>
</x-form.select>

<x-form.input type="date" name="start_date" label='<i class="fas fa-calendar-plus text-muted ms-1"></i> تاريخ البدء'
              :value="old('start_date', $research->start_date ?? '')" />

<x-form.select name="publication_status" label='<i class="fas fa-newspaper text-muted ms-1"></i> حالة النشر'>
    <option value="draft" @selected(old('publication_status', $research->publication_status ?? '') == 'draft')>مسودة</option>
    <option value="submitted" @selected(old('publication_status', $research->publication_status ?? '') == 'submitted')>تم التقديم</option>
    <option value="under_review" @selected(old('publication_status', $research->publication_status ?? '') == 'under_review')>قيد المراجعة</option>
    <option value="accepted" @selected(old('publication_status', $research->publication_status ?? '') == 'accepted')>تم القبول</option>
    <option value="published" @selected(old('publication_status', $research->publication_status ?? '') == 'published')>تم النشر</option>
</x-form.select>

<x-form.input type="range" name="completion_percentage" label='<i class="fas fa-percentage text-muted ms-1"></i> نسبة الإنجاز'
              :value="old('completion_percentage', $research->completion_percentage ?? 0)" min="0" max="100" step="5" />
<div class="text-center" id="completion-value">0%</div>

<x-form.input type="file" name="file" label='<i class="fas fa-file-alt text-muted ms-1"></i> ملف البحث' class="form-control"/>

<x-form.textarea name="abstract" label='<i class="fas fa-align-left text-muted ms-1"></i> ملخص البحث'>
    {{ old('abstract', $research->abstract ?? '') }}
</x-form.textarea>

<x-form.input name="keywords" label='<i class="fas fa-key text-muted ms-1"></i> الكلمات المفتاحية' :value="old('keywords', $research->keywords ?? '')" />
<small class="text-muted">افصل بين الكلمات بفاصلة</small>

<div class="mb-3">
    <label class="form-label"><i class="fas fa-book text-muted ms-1"></i> المجلات</label>
    <div class="row mb-3">
        <div class="col-md-4">
            <select class="form-select" id="journal-type">
                <option value="local">محلي</option>
                <option value="international">عالمي</option>
                <option value="scopus">عالمي ضمن مستوعبات سكوبس</option>
                <option value="clarivate">عالمي ضمن مستوعبات كلاريفيت</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" id="journal-name" placeholder="اسم المجلة">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-primary w-100" onclick="addJournal()">
                <i class="fas fa-plus"></i> إضافة
            </button>
        </div>
    </div>
    
    <div id="journals-list" class="mb-2">
        @if($research && $research->journals)
            @foreach($research->journals as $journal)
                <div class="journal-item mb-2">
                    <input type="hidden" name="journals[{{ $loop->index }}][id]" value="{{ $journal->id }}">
                    <input type="hidden" name="journals[{{ $loop->index }}][type]" value="{{ $journal->type }}">
                    <input type="hidden" name="journals[{{ $loop->index }}][name]" value="{{ $journal->name }}">
                    <div class="d-flex justify-content-between align-items-center p-2 border rounded">
                        <span>{{ $journal->name }} ({{ $journalTypeText[$journal->type] ?? $journal->type }})</span>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeJournal(this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<x-form.textarea name="notes" label='<i class="fas fa-sticky-note text-muted ms-1"></i> ملاحظات'>
    {{ old('notes', $research->notes ?? '') }}
</x-form.textarea>

<div class="row">
    <div class="col-md-12">
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
                @endif
                <div class="row mb-2">
                    <div class="col-md-8">
                        <select class="form-select" name="professors[]">
                            <option value="">اختر أستاذ</option>
                            @if(isset($professors))
                                @foreach($professors as $professor)
                                    <option value="{{ $professor->id }}">{{ $professor->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="professor_roles[]">
                            <option value="supervisor">مشرف</option>
                            <option value="reviewer">مراجع</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addProfessorField()">
                <i class="fas fa-plus"></i> إضافة أستاذ
            </button>
        </div>
    </div>
</div>

<x-button.primary>{{ $isEdit ? 'تحديث' : 'حفظ' }}</x-button.primary>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحديث قيمة نسبة الإنجاز
    const completionInput = document.querySelector('input[name="completion_percentage"]');
    const completionValue = document.getElementById('completion-value');
    if (completionInput && completionValue) {
        completionValue.textContent = completionInput.value + '%';
        completionInput.addEventListener('input', function() {
            completionValue.textContent = this.value + '%';
        });
    }
});

function getJournalTypeText(type) {
    const types = {
        'local': 'محلي',
        'international': 'عالمي',
        'scopus': 'عالمي ضمن مستوعبات اسكوبس',
        'clarivate': 'عالمي ضمن مستوعبات كلاريفيت'
    };
    return types[type] || type;
}

function addJournal() {
    const type = document.getElementById('journal-type').value;
    const name = document.getElementById('journal-name').value.trim();
    
    if (!name) {
        alert('الرجاء إدخال اسم المجلة');
        return;
    }
    
    const journalsList = document.getElementById('journals-list');
    const index = journalsList.children.length;
    
    const journalItem = document.createElement('div');
    journalItem.className = 'journal-item mb-2';
    journalItem.innerHTML = `
        <input type="hidden" name="journals[${index}][type]" value="${type}">
        <input type="hidden" name="journals[${index}][name]" value="${name}">
        <div class="d-flex justify-content-between align-items-center p-2 border rounded">
            <span>${name} (${getJournalTypeText(type)})</span>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeJournal(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    journalsList.appendChild(journalItem);
    document.getElementById('journal-name').value = '';
}

function removeJournal(button) {
    button.closest('.journal-item').remove();
    // تحديث الفهارس
    const journalsList = document.getElementById('journals-list');
    journalsList.querySelectorAll('.journal-item').forEach((item, index) => {
        item.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        });
    });
}
</script>
@endpush 