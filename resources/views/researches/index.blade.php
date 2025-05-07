@extends('layouts.app')
@section('title','البحوث')

@section('content')
    <div class="container-fluid py-3">
        {{-- بطاقات الإحصائيات --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            <div class="col">
                <x-stat-card color="primary"  :value="$stats['total']"        icon="microscope" title="إجمالي البحوث"/>
            </div>
            <div class="col">
                <x-stat-card color="success"  :value="$stats['in_progress']"  icon="spinner"    title="بحوث قيد التنفيذ"/>
            </div>
            <div class="col">
                <x-stat-card color="info"     :value="$stats['completed']"    icon="check"      title="بحوث مكتملة"/>
            </div>
            <div class="col">
                <x-stat-card color="danger"   :value="$stats['cancelled']"    icon="times"      title="بحوث ملغية"/>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
                    <h5 class="h5 mb-0">البحوث</h5>
                <div class="d-flex gap-2">
                        <x-button color="black" icon="plus" text="إضافة بحث جديد" :href="route('researches.create')" />
                        <a href="{{ route('researches.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> تصدير Excel
                        </a>
                    </div>
                </div>


            <div class="card-body">

                @include('partials.alerts')

                {{-- فلاتر البحث --}}
                <form method="GET" action="{{ route('researches.index') }}" class="row gy-2 gx-2 align-items-end mb-4">
                    <div class="col-12 col-lg-3">
                        <input type="text" name="title" class="form-control" placeholder="ابحث عن عنوان بحث..." value="{{ request('title') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">كل الحالات</option>
                            @foreach(\App\Models\Research::getStatuses() as $key => $label)
                                <option value="{{ $key }}" @selected(request('status') == $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="student" class="form-control" placeholder="ابحث باسم طالب..." value="{{ request('student') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="professor" class="form-control" placeholder="ابحث باسم أستاذ..." value="{{ request('professor') }}">
                    </div>
                    <div class="col-12 col-lg-1 d-grid">
                        <x-button color="black" icon="search" text="بحث" type="submit" />
                    </div>
                </form>

                {{-- جدول البحوث --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle custom-table datatable">
                        <thead class="table-light">
                        <thead>
                            <tr>
                                <th>التسلسل</th>
                                <th>{!! sort_link('العنوان','title') !!}</th>
                                <th>{!! sort_link('الطلاب','students') !!}</th>
                                <th>{!! sort_link('الأساتذة','professors') !!}</th>
                                <th>{!! sort_link('الحالة','status') !!}</th>
                                <th>المرفقات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($researches as $research)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $research->title }}</td>
                                    <td>
                                        @foreach($research->students as $student)
                                            <span class="badge bg-info">{{ $student->name }} ({{ $student->pivot->role }})</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($research->professors as $professor)
                                            <span class="badge bg-success">{{ $professor->name }} ({{ $professor->pivot->role }})</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($research->status == 'in_progress')
                                            <span class="badge bg-warning">جاري</span>
                                        @elseif($research->status == 'completed')
                                            <span class="badge bg-info">مكتمل</span>
                                        @elseif($research->status == 'cancelled')
                                            <span class="badge bg-danger">موقوف</span>
                                        @else
                                            <span class="badge bg-secondary">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($research->file_path)
                                            <a href="{{ route('researches.download', $research) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i> تحميل
                                            </a>
                                        @else
                                            <span class="text-muted">لا يوجد ملف</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('researches.edit', $research) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('researches.destroy', $research) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا البحث؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">لا توجد بحوث</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div >
                    {{ $researches->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
