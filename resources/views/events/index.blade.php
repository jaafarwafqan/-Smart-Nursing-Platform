@extends('layouts.app')
@section('title', 'إدارة الفعاليات')

@section('content')
    <div class="container-fluid py-3">

        {{-- بطاقات الإحصاء --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            <x-stat-card color="primary"  :value="\App\Models\Event::count()"                       icon="calendar-check" title="إجمالي الفعاليات"/>
            <x-stat-card color="success"  :value="\App\Models\Event::where('event_datetime','>',now())->count()" icon="clock" title="الفعاليات القادمة"/>
            <x-stat-card color="info"     :value="\App\Models\Event::sum('attendance')"            icon="users" title="إجمالي المشاركين"/>
            <x-stat-card color="warning"  :value="round(\App\Models\Event::avg('attendance'))"     icon="chart-line" title="متوسط المشاركين"/>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
                <h3 class="h5 mb-0">إدارة الفعاليات</h3>
                <div>
                    <a href="{{ route('events.create') }}"  class="btn btn-sm btn-primary ms-2">
                        <i class="fas fa-plus"></i> إضافة فعالية
                    </a>
                    <a href="{{ route('events.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> تصدير Excel
                    </a>
                </div>
            </div>

            <div class="card-body">

                @include('partials.alerts')

                {{-- فلاتر البحث --}}
                <form method="GET" action="{{ route('events.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <x-form.select name="event_type" label="نوع الفعالية">
                                <option value="">الكل</option>
                                @foreach(config('types.event_types', []) as $type)
                                    <option value="{{ $type }}" @selected(request('event_type')==$type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>

                        <div class="col-md-3">
                            <x-form.input name="event_title" label="عنوان الفعالية"
                                          :value="request('event_title')" placeholder="ابحث عن فعالية..."/>
                        </div>

                        <div class="col-md-3">
                            <x-form.select name="branch" label="الفرع">
                                <option value="">الكل</option>
                                @foreach(config('branches', []) as $branch)
                                    <option value="{{ $branch }}" @selected(request('branch')==$branch)>
                                        {{ $branch }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>

                        <div class="col-md-3 align-self-end">
                            <x-button.primary class="w-100">
                                <i class="fas fa-search"></i> بحث
                            </x-button.primary>
                        </div>
                    </div>
                </form>

                {{-- جدول الفعاليات --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>التسلسل</th>
                            <th>{!! sort_link('نوع الفعالية', 'event_type') !!}</th>
                            <th>{!! sort_link('عنوان الفعالية', 'event_title') !!}</th>
                            <th>{!! sort_link('التاريخ والوقت', 'event_datetime') !!}</th>
                            <th>{!! sort_link('الموقع', 'location') !!}</th>
                            <th>{!! sort_link('الفرع', 'branch') !!}</th>
                            <th>المرفقات</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $event->event_type }}</td>
                                <td>{{ $event->event_title }}</td>
                                <td>{{ $event->event_datetime }}</td>
                                <td>{{ $event->location }}</td>
                                <td>{{ $event->branch }}</td>

                                {{-- المرفقات --}}
                                <td>
                                    @forelse ($event->attachments as $att)
                                        <a href="{{ asset('storage/'.$att->path) }}" target="_blank">عرض</a><br>
                                        @empty
                                            &mdash;
                                    @endforelse
                                </td>

                                {{-- الإجراءات --}}
                                <td class="text-center">
                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>

                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('حذف هذه الفعالية؟');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
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
