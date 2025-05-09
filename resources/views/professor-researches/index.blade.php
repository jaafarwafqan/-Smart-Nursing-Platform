@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">
    {{-- بطاقات الإحصائيات --}}
    <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
        <div class="col">
            <x-stat-card color="primary" :value="$totalProfessors" icon="chalkboard-teacher" title="إجمالي الأساتذة"/>
        </div>
        <div class="col">
            <x-stat-card color="success" :value="$activeProfessors" icon="user-check" title="الأساتذة النشطين"/>
        </div>
        <div class="col">
            <x-stat-card color="info" :value="$publishedResearches" icon="book" title="البحوث المنشورة"/>
        </div>
        <div class="col">
            <x-stat-card color="danger" :value="$scopusIndexed + $clarivateIndexed" icon="journal-whills" title="البحوث المفهرسة"/>
        </div>
    </div>

    {{-- العنوان والأزرار --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="h5 mb-0">بحوث الأساتذة</h5>
        <div class="d-flex gap-2">
            <x-button color="black" icon="plus" text="إضافة بحث جديد" :href="route('professor-researches.create')" />
        </div>
    </div>

    {{-- فلاتر البحث --}}
    <form action="{{ route('professor-researches.index') }}" method="GET" class="row gy-2 gx-2 align-items-end mb-4">
        <div class="col-12 col-lg-3">
            <input type="text" name="title" class="form-control" placeholder="ابحث عن عنوان بحث..." value="{{ request('title') }}">
        </div>
        <div class="col-12 col-lg-3">
            <select name="professor" class="form-select">
                <option value="">اختر الأستاذ</option>
                @foreach($professors as $professor)
                    <option value="{{ $professor->id }}" {{ request('professor') == $professor->id ? 'selected' : '' }}>
                        {{ $professor->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-lg-2">
            <select name="research_type" class="form-select">
                <option value="">نوع البحث</option>
                <option value="qualitative" {{ request('research_type') == 'qualitative' ? 'selected' : '' }}>نوعي</option>
                <option value="quantitative" {{ request('research_type') == 'quantitative' ? 'selected' : '' }}>كمي</option>
            </select>
        </div>
        <div class="col-12 col-lg-2">
            <select name="publication_status" class="form-select">
                <option value="">حالة النشر</option>
                <option value="draft" {{ request('publication_status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                <option value="submitted" {{ request('publication_status') == 'submitted' ? 'selected' : '' }}>تم التقديم</option>
                <option value="under_review" {{ request('publication_status') == 'under_review' ? 'selected' : '' }}>قيد المراجعة</option>
                <option value="accepted" {{ request('publication_status') == 'accepted' ? 'selected' : '' }}>تم القبول</option>
                <option value="published" {{ request('publication_status') == 'published' ? 'selected' : '' }}>تم النشر</option>
            </select>
        </div>
        <div class="col-12 col-lg-2 d-grid">
            <x-button color="black" icon="search" text="بحث" type="submit" />
        </div>
    </form>

    {{-- جدول البحوث --}}
    <div class="table-responsive">   {{-- أبقه لو تريد الـ scroll فى الشاشات الصغيرة --}}
        <table class="table w-100 table-bordered table-hover align-middle custom-table">
            <thead class="table-light text-nowrap">
                    <tr>
                        <th>التسلسل</th>
                        <th>{!! sort_link('العنوان','title') !!}</th>
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
                                    <span class="badge bg-info">{{ $journal->name }} ({{ $journal->type ?? '' }})</span>
                                @endforeach
                            </td>
                            <td>
                                @if($research->file_path)
                                    <a href="{{ Storage::url($research->file_path) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-download"></i> تحميل
                                    </a>
                                @else
                                    <span class="text-muted">لا يوجد ملف</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('professor-researches.edit', $research) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('professor-researches.destroy', $research) }}" method="POST" class="d-inline">
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
        <div>
            {{ $researches->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
