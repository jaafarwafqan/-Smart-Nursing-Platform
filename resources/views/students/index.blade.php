@extends('layouts.app')
@section('title','قائمة الطلاب')

@section('content')
<div class="container py-4">
    {{-- بطاقات إحصائية --}}
    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <x-stat-card color="primary" icon="users" :value="$stats['total'] ?? 0" title="إجمالي الطلاب"/>
        </div>
        <div class="col">
            <x-stat-card color="success" icon="user-graduate" :value="$stats['ug'] ?? 0" title="طلاب أولية"/>
        </div>
        <div class="col">
            <x-stat-card color="info" icon="user-tie" :value="$stats['pg'] ?? 0" title="طلاب دراسات عليا"/>
        </div>
        <div class="col">
            <x-stat-card color="warning" icon="venus-mars" :value="$stats['female'] ?? 0" title="طالبات"/>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">إدارة الطلاب</h3>
            <div class="d-flex gap-2">
                <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> إضافة طالب
                </a>
                <a href="{{ route('students.import.form') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-file-import"></i> استيراد Excel
                </a>
                <a href="{{ route('students.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel"></i> تصدير Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('partials.alerts')
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <x-form.input name="search" label="بحث نصي" :value="request('search')" placeholder="اسم أو رقم جامعي"/>
                </div>
                <div class="col-md-3">
                    <x-form.select name="study_type" label="نوع الدراسة">
                        <option value="">الكل</option>
                        <option value="أولية" @selected(request('study_type')=='أولية')>أولية</option>
                        <option value="ماجستير" @selected(request('study_type')=='ماجستير')>ماجستير</option>
                        <option value="دكتوراه" @selected(request('study_type')=='دكتوراه')>دكتوراه</option>
                    </x-form.select>
                </div>
                <div class="col-md-3">
                    <x-form.select name="gender" label="الجنس">
                        <option value="">الكل</option>
                        <option value="ذكر" @selected(request('gender')=='ذكر')>ذكر</option>
                        <option value="أنثى" @selected(request('gender')=='أنثى')>أنثى</option>
                    </x-form.select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <x-button.primary class="w-100">
                        <i class="fas fa-search"></i> بحث
                    </x-button.primary>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle custom-table datatable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{!! sort_link('الاسم','name') !!}</th>
                            <th>{!! sort_link('الجنس','gender') !!}</th>
                            <th>{!! sort_link('تاريخ الميلاد','birthdate') !!}</th>
                            <th>{!! sort_link('الرقم الجامعي','university_number') !!}</th>
                            <th>{!! sort_link('نوع الدراسة','study_type') !!}</th>
                            <th>{!! sort_link('سنة الدراسة/البرنامج','study_year') !!}</th>
                            <th>{!! sort_link('الهاتف','phone') !!}</th>
                            <th>{!! sort_link('البريد الإلكتروني','email') !!}</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->birthdate }}</td>
                            <td>{{ $student->university_number }}</td>
                            <td>{{ $student->study_type }}</td>
                            <td>{{ $student->study_type == 'أولية' ? $student->study_year : $student->program }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->email }}</td>
                            <td class="text-center">
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">تعديل</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center">لا يوجد طلاب</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $students->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection 