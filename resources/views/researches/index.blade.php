@extends('layouts.app')
@section('title','البحوث')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">قائمة البحوث</h1>

            <a href="{{ route('researches.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> إضافة بحث
            </a>
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
