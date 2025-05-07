@extends('layouts.app')
@section('title','البحوث')

@section('content')
    <div class="container-fluid py-3">
        {{-- بطاقات الإحصائيات --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            @if(request('view') === 'professors')
                <div class="col">
                    <x-stat-card color="primary" :value="$stats['total_professors']" icon="chalkboard-teacher" title="إجمالي الأساتذة"/>
                </div>
                <div class="col">
                    <x-stat-card color="success" :value="$stats['active_professors']" icon="user-check" title="الأساتذة النشطين"/>
                </div>
                <div class="col">
                    <x-stat-card color="info" :value="$stats['published_researches']" icon="book" title="البحوث المنشورة"/>
                </div>
                <div class="col">
                    <x-stat-card color="warning" :value="$stats['scopus_researches'] + $stats['clarivate_researches']" icon="journal-whills" title="بحوث في مستوعبات عالمية"/>
                </div>
            @else
                <div class="col">
                    <x-stat-card color="primary" :value="$stats['total']" icon="microscope" title="إجمالي البحوث"/>
                </div>
                <div class="col">
                    <x-stat-card color="success" :value="$stats['in_progress']" icon="spinner" title="بحوث قيد التنفيذ"/>
                </div>
                <div class="col">
                    <x-stat-card color="info" :value="$stats['completed']" icon="check" title="بحوث مكتملة"/>
                </div>
                <div class="col">
                    <x-stat-card color="danger" :value="$stats['cancelled']" icon="times" title="بحوث ملغية"/>
                </div>
            @endif
        </div>

        {{-- العنوان والأزرار --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="h5 mb-0">البحوث</h5>
            <div class="d-flex gap-2">
                <x-button color="black" icon="plus" text="إضافة بحث جديد" :href="route('researches.create')" />
                <a href="{{ route('researches.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> تصدير Excel
                </a>
            </div>
        </div>

        {{-- فلاتر البحث --}}
        <form method="GET" action="{{ route('researches.index') }}" class="row gy-2 gx-2 align-items-end mb-4">
            @if(request('view') === 'professors')
                <input type="hidden" name="view" value="professors">
            @endif
            <div class="col-12 col-lg-3">
                <input type="text" name="title" class="form-control" placeholder="ابحث عن عنوان بحث..." value="{{ request('title') }}">
            </div>
            <div class="col-12 col-lg-2">
                <select name="publication_status" class="form-select">
                    <option value="">كل حالات النشر</option>
                    @foreach(\App\Models\Research::getPublicationStatuses() as $key => $label)
                        <option value="{{ $key }}" @selected(request('publication_status') == $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-lg-3">
                <input type="text" name="professor" class="form-control" placeholder="ابحث باسم أستاذ..." value="{{ request('professor') }}">
            </div>
            <div class="col-12 col-lg-3">
                <select name="journal_type" class="form-select">
                    <option value="">كل أنواع المجلات</option>
                    <option value="local" @selected(request('journal_type') == 'local')>محلي</option>
                    <option value="international" @selected(request('journal_type') == 'international')>عالمي</option>
                    <option value="scopus" @selected(request('journal_type') == 'scopus')>عالمي ضمن مستوعبات سكوبس</option>
                    <option value="clarivate" @selected(request('journal_type') == 'clarivate')>عالمي ضمن مستوعبات كلاريفيت</option>
                </select>
            </div>
            <div class="col-12 col-lg-1 d-grid">
                <x-button color="black" icon="search" text="بحث" type="submit" />
            </div>
        </form>

        {{-- جدول البحوث --}}
        <div class="bg-white p-3 rounded-3">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle custom-table datatable">
                    <thead class="table-light">
                        <tr>
                            <th>التسلسل</th>
                            <th>{!! sort_link('العنوان','title') !!}</th>
                            <th>{!! sort_link('الطلاب','students') !!}</th>
                            <th>{!! sort_link('الأساتذة','professors') !!}</th>
                            <th>{!! sort_link('حالة النشر','publication_status') !!}</th>
                            <th>المجلات</th>
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
                                        <span class="badge bg-primary">{{ $student->name }} ({{ $student->pivot->role ?? '' }})</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($research->professors as $professor)
                                        <span class="badge bg-success">{{ $professor->name }} ({{ $professor->pivot->role ?? '' }})</span>
                                    @endforeach
                                </td>
                                <td>
                                    @if($research->publication_status == 'draft')
                                        <span class="badge bg-secondary">مسودة</span>
                                    @elseif($research->publication_status == 'submitted')
                                        <span class="badge bg-info">تم التقديم</span>
                                    @elseif($research->publication_status == 'under_review')
                                        <span class="badge bg-warning">قيد المراجعة</span>
                                    @elseif($research->publication_status == 'accepted')
                                        <span class="badge bg-primary">تم القبول</span>
                                    @elseif($research->publication_status == 'published')
                                        <span class="badge bg-success">تم النشر</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($research->journals as $journal)
                                        <span class="badge bg-info">{{ $journal->name }} ({{ $journal->type }})</span>
                                    @endforeach
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
                                <td colspan="8" class="text-center">لا توجد بحوث</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div>
                {{ $researches->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
