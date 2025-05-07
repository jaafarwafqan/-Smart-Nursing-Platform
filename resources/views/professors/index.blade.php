@extends('layouts.app')
@section('title','قائمة الأساتذة')

@section('content')
<div class="container py-4">
    {{-- بطاقات إحصائية افتراضية --}}
    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <x-stat-card color="primary" icon="users" :value="$stats['total'] ?? 0" title="إجمالي الأساتذة"/>
        </div>
        <div class="col">
            <x-stat-card color="success" icon="chalkboard-teacher" :value="$stats['professors'] ?? 0" title="أساتذة"/>
        </div>
        <div class="col">
            <x-stat-card color="info" icon="user-tie" :value="$stats['assistants'] ?? 0" title="أساتذة مساعدين"/>
        </div>
        <div class="col">
            <x-stat-card color="warning" icon="venus-mars" :value="$stats['female'] ?? 0" title="أستاذات"/>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">إدارة الأساتذة</h3>
            <div class="d-flex gap-2">
                <x-button color="black" icon="plus" text="إضافة أستاذ" :href="route('professors.create')" />
                <a href="{{ route('professors.import.form') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-file-import"></i> استيراد Excel
                </a>
                <a href="{{ route('professors.export') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel"></i> تصدير Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            @include('partials.alerts')
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <x-form.input name="search" label="بحث نصي" :value="request('search')" placeholder="اسم أو كلية"/>
                </div>
                <div class="col-md-3">
                    <x-form.select name="academic_rank" label="الرتبة العلمية">
                        <option value="">الكل</option>
                        <option value="أستاذ" @selected(request('academic_rank')=='أستاذ')>أستاذ</option>
                        <option value="أستاذ مساعد" @selected(request('academic_rank')=='أستاذ مساعد')>أستاذ مساعد</option>
                        <option value="مدرس" @selected(request('academic_rank')=='مدرس')>مدرس</option>
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
                            <th>الاسم</th>
                            <th>الجنس</th>
                            <th>الرتبة العلمية</th>
                            <th>الكلية</th>
                            <th>القسم</th>
                            <th>مجالات الاهتمام</th>
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($professors as $professor)
                        <tr>
                            <td>{{ $professor->id }}</td>
                            <td>{{ $professor->name }}</td>
                            <td>{{ $professor->gender }}</td>
                            <td>{{ $professor->academic_rank }}</td>
                            <td>{{ $professor->college }}</td>
                            <td>{{ $professor->department }}</td>
                            <td>{{ $professor->research_interests }}</td>
                            <td>{{ $professor->phone }}</td>
                            <td>{{ $professor->email }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('professors.edit', $professor) }}" class="btn btn-sm btn-primary" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('professors.destroy', $professor) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center">لا يوجد أساتذة</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $professors->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
