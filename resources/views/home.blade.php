{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('title', 'الصفحة الرئيسية')

@section('content')
    <div class="bg-primary text-white text-center position-relative overflow-hidden" style="padding: 100px 0;">
        <div class="container position-relative" style="z-index: 1;">
            <h1 class="display-4 fw-bold mb-3">منصة التمريض الذكية</h1>
            <p class="lead mb-4 opacity-75">نظام متكامل لإدارة الحملات والفعاليات والبحوث بكفاءة عالية</p>
            @auth
                <a href="{{ route('dashboard.index') }}" class="btn btn-light btn-lg me-2">لوحة التحكم <i class="fas fa-tachometer-alt ms-1"></i></a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg me-2">تسجيل الدخول <i class="fas fa-sign-in-alt ms-1"></i></a>
                <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">حول النظام <i class="fas fa-info-circle ms-1"></i></a>
            @endauth
        </div>
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('{{ asset('images/hero-shape.svg') }}') center/cover no-repeat; opacity: 0.2;"></div>
    </div>

    <div class="container my-5">
        {{-- إحصائيات سريعة --}}
        <div class="row g-4 mb-5 text-center">
            @foreach([
                ['icon'=>'calendar-check','count'=>\App\Models\Event::count(),'label'=>'الفعاليات','color'=>'primary'],
                ['icon'=>'bullhorn','count'=>\App\Models\Campaign::count(),'label'=>'الحملات','color'=>'success'],
                ['icon'=>'microscope','count'=>class_exists(\App\Models\researches::class) ? \App\Models\researches::count() : 0,'label'=>'البحوث','color'=>'info'],
                ['icon'=>'users','count'=>\App\Models\User::count(),'label'=>'المستخدمين','color'=>'warning'],
            ] as $stat)
                <div class="col-sm-6 col-lg-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="mb-3 text-{{ $stat['color'] }}">
                                <i class="fas fa-{{ $stat['icon'] }} fa-2x"></i>
                            </div>
                            <h2 class="fw-bold counter mb-1">{{ $stat['count'] }}</h2>
                            <p class="text-muted mb-0">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- الأقسام الرئيسية --}}
        <div class="row g-4">
            @can('manage_events')
                <div class="col-md-6 col-lg-3">
                    <div class="card feature shadow-sm border-0 h-100 hover-scale">
                        <div class="card-body text-center">
                            <div class="mb-3 text-primary">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <h5 class="fw-bold mb-2">إدارة الفعاليات</h5>
                            <p class="text-muted mb-4">تنظيم وجدولة فعاليات تمريض احترافية</p>
                            <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm">عرض <i class="fas fa-arrow-left ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endcan
            @can('manage_campaigns')
                <div class="col-md-6 col-lg-3">
                    <div class="card feature shadow-sm border-0 h-100 hover-scale">
                        <div class="card-body text-center">
                            <div class="mb-3 text-success">
                                <i class="fas fa-bullhorn fa-2x"></i>
                            </div>
                            <h5 class="fw-bold mb-2">إدارة الحملات</h5>
                            <p class="text-muted mb-4">تخطيط وتنفيذ الحملات التوعوية بكفاءة</p>
                            <a href="{{ route('campaigns.index') }}" class="btn btn-outline-success btn-sm">عرض <i class="fas fa-arrow-left ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endcan
            @can('manage_researches')
                <div class="col-md-6 col-lg-3">
                    <div class="card feature shadow-sm border-0 h-100 hover-scale">
                        <div class="card-body text-center">
                            <div class="mb-3 text-info">
                                <i class="fas fa-flask fa-2x"></i>
                            </div>
                            <h5 class="fw-bold mb-2">وحدة البحوث</h5>
                            <p class="text-muted mb-4">إدارة مقترحات ومشاريع البحوث</p>
                            <a href="#" class="btn btn-outline-info btn-sm">عرض <i class="fas fa-arrow-left ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endcan
            @can('manage_users')
                <div class="col-md-6 col-lg-3">
                    <div class="card feature shadow-sm border-0 h-100 hover-scale">
                        <div class="card-body text-center">
                            <div class="mb-3 text-danger">
                                <i class="fas fa-user-cog fa-2x"></i>
                            </div>
                            <h5 class="fw-bold mb-2">إدارة المستخدمين</h5>
                            <p class="text-muted mb-4">تعيين الأدوار والصلاحيات بسهولة</p>
                            <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm">عرض <i class="fas fa-arrow-left ms-1"></i></a>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    @push('styles')
        <style>
            .hover-scale:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); transition: all .3s ease; }
            .counter { font-size: 2rem; }
            @media (max-width: 576px) { .display-4 { font-size: 2rem; } }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.counter').forEach(el => {
                    let target = +el.textContent;
                    el.textContent = '0';
                    let count = 0;
                    const step = Math.ceil(target / 60);
                    const update = () => {
                        count += step;
                        el.textContent = count > target ? target : count;
                        if(count < target) requestAnimationFrame(update);
                    };
                    update();
                });
            });
        </script>
    @endpush
@endsection
