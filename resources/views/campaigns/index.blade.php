{{-- resources/views/campaigns/index.blade.php --}}
@extends('layouts.app')
@section('title','إدارة الحملات')

@section('content')
    <div class="container-fluid py-3">

        {{-- تنبيهات --}}
        @include('partials.alerts')

        {{-- بطاقات الإحصاء --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            <div class="col">
            <x-stat-card color="dark"    icon="clipboard-list" :value="$stats['total_campaigns']     ?? 0" title="إجمالي الحملات"/>
            </div>
            <div class="col">
            <x-stat-card color="success" icon="users"          :value="$stats['total_participants']   ?? 0" title="إجمالي المشاركين"/>
            </div>
            <div class="col">
            <x-stat-card color="primary" icon="clock"          :value="$stats['pending_campaigns']   ?? 0" title="الحملات القادمة"/>
            </div>
            <div class="col">
            <x-stat-card color="warning" icon="chart-line"     :value="$stats['average_participants']?? 0" title="متوسط المشاركين"/>
            </div>
        </div>

        {{-- غلاف البطاقة --}}
        <div class="card shadow-sm">

            {{-- رأس البطاقة --}}
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">إدارة الحملات</h5>
                <div class="d-flex gap-2">
                        <a href="{{ route('campaigns.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> إضافة حملة
                        </a>
                    <a href="{{ route('campaigns.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> تصدير Excel
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- فلاتر --}}
                <form method="GET" action="{{ route('campaigns.index') }}"
                      class="row gy-2 gx-2 align-items-end mb-4">

                    <div class="col-12 col-lg-3">
                        <label class="form-label mb-1">الفرع</label>
                        <select name="branch" class="form-select">
                            <option value="">الكل</option>
                            @foreach(config('branches',[]) as $branch)
                                <option value="{{ $branch }}" @selected(request('branch')==$branch)>{{ $branch }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-lg-3">
                        <label class="form-label mb-1">عنوان الحملة</label>
                        <input name="search" class="form-control" placeholder="ابحث عن حملة…"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-6 col-lg-2">
                        <label class="form-label mb-1">من</label>
                        <input type="date" name="start_date" class="form-control"
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="col-6 col-lg-2">
                        <label class="form-label mb-1">إلى</label>
                        <input type="date" name="end_date" class="form-control"
                               value="{{ request('end_date') }}">
                    </div>

                    <div class="col-12 col-lg-2 d-grid">
                        <button class="btn btn-dark"><i class="fas fa-search"></i> بحث</button>
                    </div>
                </form>

                {{-- جدول الحملات --}}
                {{-- ✅ جدول الحملات --}}
                <div class="table-responsive">   {{-- أبقه لو تريد الـ scroll فى الشاشات الصغيرة --}}
                    <table class="table w-100 table-bordered table-hover align-middle custom-table">
                        <thead class="table-light text-nowrap">
                        <tr>
                            <th>التسلسل</th>
                            <th>{!! sort_link('عنوان الحملة','title')     !!}</th>
                            <th>{!! sort_link('الفرع','branch_id')         !!}</th>
                            <th>{!! sort_link('تاريخ البداية','start_date')!!}</th>
                            <th>{!! sort_link('تاريخ النهاية','end_date')  !!}</th>
                            <th>المنظمون</th>
                            <th>المرفقات</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                        </thead>

                        <tbody class="text-nowrap">
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td>{{ $loop->iteration + ($campaigns->currentPage()-1)*$campaigns->perPage() }}</td>
                                <td>{{ $campaign->title }}</td>
                                <td>{{ $campaign->branch?->name ?? '—' }}</td>
                                <td>{{ optional($campaign->start_date)->format('Y-m-d') }}</td>
                                <td>{{ optional($campaign->end_date)->format('Y-m-d') }}</td>

                                {{-- المنظمون --}}
                                <td>
                                    @forelse ($campaign->organizers ?? [] as $org)
                                        <span class="badge bg-light text-dark">{{ $org }}</span>
                                        @empty &mdash;
                                    @endforelse
                                </td>

                                {{-- المرفقات --}}
                                <td>
                                    @forelse ($campaign->attachments ?? [] as $file)
                                        <a href="{{ asset('storage/campaigns/'.$file) }}" class="attachment-link d-block">
                                            <i class="fas fa-file-download"></i>
                                            {{ \Str::limit($file,15) }}
                                        </a>
                                        @empty &mdash; @endforelse
                                </td>

                                {{-- الإجراءات --}}
                                <td class="text-center">
                                    <a href="{{ route('campaigns.edit',$campaign) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('campaigns.destroy',$campaign) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('حذف هذه الحملة؟');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">لا توجد حملات</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>


                {{ $campaigns->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
