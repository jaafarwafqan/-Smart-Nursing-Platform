@extends('layouts.app')

@section('title', 'ملفي الشخصي')

@section('content')
    <main class="container py-4">

        <h2 class="text-center mb-4"><i class="fas fa-user-cog"></i> تعديل المعلومات الشخصية</h2>
        <div class="row g-4">
            {{-- رسائل نجاح / خطأ --}}
            @include('partials.alerts')
            {{-- معلومات المستخدم --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-id-card-alt"></i> بياناتي
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
                            @csrf
                            @method('PUT')

                            <x-form.input
                                class="col-12"
                                name="name"
                                label="الاسم"
                                :value="old('name', auth()->user()->name)"
                                required
                            />

                            <x-form.input
                                class="col-12"
                                type="email"
                                name="email"
                                label="البريد الإلكتروني"
                                :value="old('email', auth()->user()->email)"
                                required
                            />

                            <div class="col-12 text-end">
                                <x-button.primary>
                                    <i class="fas fa-save"></i> حفظ
                                </x-button.primary>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- تغيير كلمة المرور --}}
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-warning text-dark">
                        <i class="fas fa-key"></i> كلمة المرور
                    </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.changePassword') }}" class="row g-3">
                            @csrf
                            @method('PUT')

                            <x-form.input
                                class="col-12"
                                type="password"
                                name="current_password"
                                label="كلمة المرور الحالية"
                                required
                            />

                            <x-form.input
                                class="col-12"
                                type="password"
                                name="new_password"
                                label="كلمة المرور الجديدة"
                                required
                            />

                            <x-form.input
                                class="col-12"
                                type="password"
                                name="new_password_confirmation"
                                label="تأكيد كلمة المرور الجديدة"
                                required
                            />

                            <div class="col-12 text-end">
                                <x-button.primary>
                                    <i class="fas fa-sync-alt"></i> تحديث
                                </x-button.primary>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
