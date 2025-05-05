@props(['professor' => null])

<div class="row g-3">
    <div class="col-md-6">
        <x-form.input name="name" label='<i class="fas fa-user-tie text-muted ms-1"></i> الاسم' :value="old('name', $professor->name ?? '')" required />
    </div>
    <div class="col-md-3">
        <x-form.select name="gender" label='<i class="fas fa-venus-mars text-muted ms-1"></i> الجنس' required>
            <option value="">اختر</option>
            <option value="ذكر" @selected(old('gender', $professor->gender ?? '')=='ذكر')>ذكر</option>
            <option value="أنثى" @selected(old('gender', $professor->gender ?? '')=='أنثى')>أنثى</option>
        </x-form.select>
    </div>
    <div class="col-md-3">
        <x-form.select name="academic_rank" label='<i class="fas fa-user-graduate text-muted ms-1"></i> الرتبة العلمية' required>
            <option value="">اختر</option>
            <option value="مدرس" @selected(old('academic_rank', $professor->academic_rank ?? '')=='مدرس')>مدرس</option>
            <option value="مدرس مساعد" @selected(old('academic_rank', $professor->academic_rank ?? '')=='مدرس مساعد')>مدرس مساعد</option>
            <option value="أستاذ" @selected(old('academic_rank', $professor->academic_rank ?? '')=='أستاذ')>أستاذ</option>
            <option value="أستاذ مساعد" @selected(old('academic_rank', $professor->academic_rank ?? '')=='أستاذ مساعد')>أستاذ مساعد</option>
        </x-form.select>
    </div>
    <div class="col-md-4">
        <x-form.input name="college" label='<i class="fas fa-university text-muted ms-1"></i> الكلية' :value="old('college', $professor->college ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input name="department" label='<i class="fas fa-building text-muted ms-1"></i> القسم' :value="old('department', $professor->department ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input name="research_interests" label='<i class="fas fa-flask text-muted ms-1"></i> مجالات الاهتمام البحثي' :value="old('research_interests', $professor->research_interests ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input name="phone" label='<i class="fas fa-phone text-muted ms-1"></i> الهاتف' :value="old('phone', $professor->phone ?? '')" />
    </div>
    <div class="col-md-4">
        <x-form.input type="email" name="email" label='<i class="fas fa-envelope text-muted ms-1"></i> البريد الإلكتروني' :value="old('email', $professor->email ?? '')" />
    </div>
    <div class="col-md-12">
        <x-form.textarea name="notes" label='<i class="fas fa-sticky-note text-muted ms-1"></i> ملاحظات'>{{ old('notes', $professor->notes ?? '') }}</x-form.textarea>
    </div>
</div> 