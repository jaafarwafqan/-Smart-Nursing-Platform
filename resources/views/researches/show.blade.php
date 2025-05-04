@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل البحث</h5>
                    <div>
                        <a href="{{ route('researches.edit', $research) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                        <a href="{{ route('researches.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> رجوع
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">معلومات البحث</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">العنوان</th>
                                    <td>{{ $research->title }}</td>
                                </tr>
                                <tr>
                                    <th>الملخص</th>
                                    <td>{{ $research->abstract ?? 'لا يوجد' }}</td>
                                </tr>
                                <tr>
                                    <th>الكلمات المفتاحية</th>
                                    <td>{{ $research->keywords ?? 'لا يوجد' }}</td>
                                </tr>
                                <tr>
                                    <th>الحالة</th>
                                    <td>
                                        <span class="badge bg-{{ $research->status == 'pending' ? 'warning' : ($research->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ $research->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>الملف</th>
                                    <td>
                                        @if($research->file_path)
                                            <a href="{{ route('researches.download', $research) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-download"></i> تحميل الملف
                                            </a>
                                        @else
                                            <span class="text-muted">لا يوجد ملف</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>الملاحظات</th>
                                    <td>{{ $research->notes ?? 'لا يوجد' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h6 class="text-muted">الطلاب المشاركون</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الدور</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($research->students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $student->pivot->role }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">لا يوجد طلاب</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <h6 class="text-muted mt-4">الأساتذة المشرفون</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الدور</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($research->professors as $professor)
                                        <tr>
                                            <td>{{ $professor->name }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $professor->pivot->role }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">لا يوجد أساتذة</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 