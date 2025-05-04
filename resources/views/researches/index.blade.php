@extends('layouts.app')
@section('title','البحوث')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">البحوث</h5>
                        <a href="{{ route('researches.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> إضافة بحث جديد
                        </a>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>العنوان</th>
                                        <th>الطلاب</th>
                                        <th>الأساتذة</th>
                                        <th>الحالة</th>
                                        <th>الملف</th>
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
                                                <span class="badge bg-{{ $research->status == 'pending' ? 'warning' : ($research->status == 'approved' ? 'success' : 'danger') }}">
                                                    {{ $research->status }}
                                                </span>
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
                                                    <a href="{{ route('researches.show', $research) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
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

                        <div class="d-flex justify-content-center mt-4">
                            {{ $researches->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
