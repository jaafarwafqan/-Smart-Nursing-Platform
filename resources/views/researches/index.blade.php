@extends('layouts.app')
@section('title','البحوث')

@section('content')
    <div class="container-fluid py-3">

        {{-- بطاقات الإحصاء --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            <div class="col">
                <x-stat-card color="primary" icon="book" :value="$stats['total']" title="إجمالي البحوث"/>
            </div>
            <div class="col">
                <x-stat-card color="success" icon="check" :value="$stats['completed']" title="البحوث المكتملة"/>
            </div>
            <div class="col">
                <x-stat-card color="warning" icon="exclamation" :value="$stats['pending']" title="البحوث المعلقة"/>
            </div>
            <div class="col">
                <x-stat-card color="danger" icon="times" :value="$stats['rejected']" title="البحوث المرفوضة"/>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
        <h1 class="h4 mb-0">قائمة البحوث</h1>
            <a href="{{ route('researches.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> إضافة بحث
            </a>

            </div>
    </div>

    <table class="table table-striped align-middle">
        <thead>
        <tr>
            <th>التسلسل</th>
            <th>العنوان</th>
            <th>النوع</th>
            <th>الفرع</th>
            <th>الحالة</th>
            <th class="text-end">العمليات</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($researches as $research)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $research->research_title }}</td>
                <td>{{ $research->research_type }}</td>
                <td>{{ $research->branch?->name ?? '—' }}</td>
                <td>
                    <x-badge color="{{ $research->status === 'مكتمل' ? 'success' : 'warning' }}">
                        {{ $research->status }}
                    </x-badge>
                </td>
                <td class="text-end">
                    @can('update', $research)
                        <a href="{{ route('researches.edit', $research) }}" class="btn btn-sm btn-primary">تعديل</a>
                    @endcan
                    @can('delete', $research)
                        <form action="{{ route('researches.destroy', $research) }}" method="post" class="d-inline"
                              onsubmit="return confirm('حذف البحث؟');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $researches->links() }}
@endsection
