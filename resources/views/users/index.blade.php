{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')
@section('title','إدارة المستخدمين')

@section('content')
    <div class="container-fluid py-3">
        {{-- بطاقات إحصاء --}}
        <div class="row row-cols-1 row-cols-lg-4 g-3 mb-4">
            <div class="col">
            <x-stat-card color="primary" icon="users" :value="$stats['total']" title="إجمالي المستخدمين"/>
            </div>
            <div class="col">
            <x-stat-card color="danger" icon="user-shield" :value="$stats['admins']" title="المدراء"/>
            </div>
            <div class="col">
            <x-stat-card color="success" icon="chalkboard-teacher" :value="$stats['professors']" title="الأساتذة"/>
            </div>
            <div class="col">
            <x-stat-card color="info" icon="user-graduate" :value="$stats['students']" title="الطلاب"/>
            </div>
        </div>

        <div class="card shadow-sm">
            {{-- رأس البطاقة --}}
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">إدارة المستخدمين</h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> إضافة مستخدم
                    </a>
                    <a href="{{ route('users.export') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> تصدير Excel
                    </a>
                </div>
            </div>

            <div class="card-body">
                @include('partials.alerts')

                {{-- فلاتر البحث --}}
                <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <x-form.input name="search" label="بحث نصي"
                                        :value="request('search')" placeholder="اسم أو بريد إلكتروني"/>
                        </div>

                        <div class="col-md-3">
                            <x-form.select name="type" label="نوع المستخدم">
                                <option value="">الكل</option>
                                @foreach($types as $key=>$val)
                                    <option value="{{ $key }}" @selected(request('type')==$key)>{{ $val }}</option>
                                @endforeach
                            </x-form.select>
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
                    </div>
                </form>

                {{-- جدول --}}
                <div class="table-responsive">
                    @php
                        // خريطة ألوان الشارة
                        $badgeColors = [
                            'admin'     => 'danger',
                            'professor' => 'primary',
                            'student'   => 'success',
                            'employee'  => 'info',
                            'other'     => 'secondary',

                        ];
                    @endphp

                    <table class="table table-bordered table-hover align-middle custom-table datatable">
                        <thead class="table-light">
                        <tr>
                            <th>التسلسل</th>
                            <th>{!! sort_link('الاسم','name') !!}</th>
                            <th>{!! sort_link('البريد الإلكتروني','email') !!}</th>
                            <th>{!! sort_link('تاريخ التسجيل','created_at') !!}</th>
                            <th>النوع</th>
                            <th>الفرع</th>
                            <th>الأدوار</th>
                            <th class="text-center">الإجراءات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ ($users->currentPage()-1)*$users->perPage() + $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('Y-m-d') }}</td>

                                {{-- شارة النوع --}}
                                <td>
                                <span class="badge bg-{{ $badgeColors[$user->type] ?? 'secondary' }}">
                                    {{ $types[$user->type] ?? $user->type }}
                                </span>
                                </td>

                                <td>{{ $user->branch?->name ?? '—' }}</td>

                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-secondary">{{ $role->name }}</span>
                                    @endforeach
                                </td>

                                {{-- إجراءات --}}
                                {{-- داخل جدول المستخدمين --}}
                                <td class="text-center">
                                    @if($user->email !== 'jaafar1@jaafar1.com')
                                        @can('update',$user)

                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('delete',$user)
                                            @if($user->id!==auth()->id())

                                                    <form action="{{ route('users.destroy',$user) }}" method="POST" style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')" title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                            @endif
                                        @endcan
                                    @else
                                        <span class="badge bg-secondary">مدير النظام</span>
                                    @endif
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <i class="fas fa-user-slash fa-2x mb-2"></i><br>لا يوجد مستخدمين
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
