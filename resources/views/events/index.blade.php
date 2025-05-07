{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')
@section('title','إدارة الفعاليات')

@section('content')
    <div class="container-fluid py-3">

        {{-- بطاقات الإحصاء --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            <div class="col">
            <x-stat-card color="primary"  :value="$stats['total']"           icon="calendar-check" title="إجمالي الفعاليات"/>
            </div>
            <div class="col">
            <x-stat-card color="success"  :value="$stats['upcoming']"        icon="clock"          title="الفعاليات القادمة"/>
            </div>
            <div class="col">
            <x-stat-card color="info"     :value="$stats['attendance_sum']"  icon="users"          title="إجمالي المشاركين"/>
            </div>
            <div class="col">
            <x-stat-card color="warning"  :value="$stats['attendance_avg']"  icon="chart-line"     title="متوسط المشاركين"/>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
                <h3 class="h5 mb-0">إدارة الفعاليات</h3>
                <div class="d-flex gap-2">
                    <x-button color="black" icon="plus" text="إضافة فعالية" :href="route('events.create')" />
                    <a href="{{ route('events.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> تصدير Excel
                    </a>
                </div>
            </div>

            <div class="card-body">

                @include('partials.alerts')

                {{-- فلاتر البحث --}}
                <form method="GET" action="{{ route('events.index') }}" class="row gy-2 gx-2 align-items-end mb-4">
                    <div class="col-12 col-lg-3">
                        <x-form.select name="event_type" label="نوع الفعالية">
                            <option value="">الكل</option>
                            @foreach($eventTypes as $type)
                                <option value="{{ $type }}" @selected(request('event_type')==$type)>{{ $type }}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-12 col-lg-3">
                        <x-form.input name="event_title" label="عنوان الفعالية"
                                      :value="request('event_title')" placeholder="ابحث عن فعالية..."/>
                    </div>

                    <div class="col-md-3">
                        <x-form.select name="branch_id" label="الفرع">
                            <option value="">الكل</option>
                            @foreach($branches as $id=>$name)
                                <option value="{{ $id }}" @selected(request('branch_id')==$id)>{{ $name }}</option>
                            @endforeach
                        </x-form.select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <x-button.primary class="w-100">
                            <i class="fas fa-search"></i> بحث
                        </x-button.primary>
                    </div>
                </form>

                {{-- جدول الفعاليات --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle custom-table datatable">
                        <thead class="table-light">
                        <tr>
                            <th>التسلسل</th>
                            <th>{!! sort_link('نوع الفعالية','event_type') !!}</th>
                            <th>{!! sort_link('عنوان الفعالية','event_title') !!}</th>
                            <th>{!! sort_link('التاريخ والوقت','event_datetime') !!}</th>
                            <th>{!! sort_link('الموقع','location') !!}</th>
                            <th>{!! sort_link('الفرع','branch') !!}</th>
                            <th>المرفقات</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ ($events->currentPage()-1)*$events->perPage() + $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $event->event_type }}</span>
                                </td>
                                <td>{{ $event->event_title }}</td>
                                <td>{{ $event->event_datetime->format('Y-m-d H:i') }}</td>
                                <td>{{ $event->location }}</td>
                                <td>{{ optional($event->branch)->name ?? '—' }}</td>


                                {{-- المرفقات --}}
                                <td>
                                    @if($event->file_path)
                                        <a href="{{ route('events.attachments', $event) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-download"></i> تحميل
                                        </a>
                                    @else
                                        <span class="text-muted">لا يوجد ملف</span>
                                    @endif
                                </td>

                                {{-- إجراءات --}}
                                <td class="text-center">
                                    @can('update',$event)
                                        <a href="{{ route('events.edit',$event) }}" class="btn btn-sm btn-primary" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete',$event)
                                        <form action="{{ route('events.destroy',$event) }}" method="POST"
                                              class="d-inline" onsubmit="return confirm('حذف هذه الفعالية؟');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">لا توجد فعاليات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $events->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
