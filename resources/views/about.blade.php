{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('title', 'حول المنصة')

@section('content')
    <div class="container-fluid p-0">
        {{-- Hero Section --}}
        <section class="hero text-center position-relative" style="padding: 100px 0;">
            <div class="container position-relative" style="z-index:1;">
                <h1 class="display-4 fw-bold mb-3 text-white">منصة التمريض الذكية</h1>
                <p class="lead mb-4 text-light">الحل الشامل لإدارة الحملات، الفعاليات، البحوث، والمستخدمين بكفاءة واحترافية</p>
                <a href="#modules" class="btn btn-primary btn-lg me-2">استكشف الوحدات</a>
                <a href="#contact" class="btn btn-outline-light btn-lg">تواصل معنا</a>
            </div>
            <div class="hero-background position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(13,110,253,0.85) 0%, rgba(13,202,240,0.85) 100%); clip-path: polygon(0 0,100% 0,100% 80%,0 100%);"></div>
        </section>

        {{-- Overview Section --}}
        <section class="py-5" id="overview">
            <div class="container">
                <h2 class="h1 text-center mb-4">لماذا منصة التمريض الذكية؟</h2>
                <p class="text-center text-muted mb-5">تم تصميم هذه المنصة لتلبية احتياجات الكوادر التمريضية والإدارية في تنظيم وإدارة الحملات والفعاليات البحثية والتعليمية، مع تقارير وتحليلات فورية ترفع من جودة الأداء.</p>
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">واجهة مستخدم سهلة</h5>
                        <p class="text-muted">تصميم وواجهة مألوفة تعتمد على Bootstrap لتجربة سلسة.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-th fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">وحدات متكاملة</h5>
                        <p class="text-muted">إدارة الحملات، الفعاليات، البحوث، والبيانات في مكان واحد.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">صلاحيات مرنة</h5>
                        <p class="text-muted">نظام Roles & Permissions دقيق لإدارة الوصول.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modules Section --}}
        <section class="bg-light py-5" id="modules">
            <div class="container">
                <h2 class="h1 text-center mb-5">الوحدات الرئيسية</h2>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 text-center p-4">
                            <i class="fas fa-bullhorn fa-2x text-primary mb-3"></i>
                            <h5 class="fw-bold mb-2">إدارة الحملات</h5>
                            <p class="text-muted">إنشاء وتحرير حملات تمريضية مع استيراد البيانات من Excel.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 text-center p-4">
                            <i class="fas fa-calendar-check fa-2x text-success mb-3"></i>
                            <h5 class="fw-bold mb-2">إدارة الفعاليات</h5>
                            <p class="text-muted">جدولة الفعاليات، تتبع الحضور، والتحميل التلقائي للمرفقات.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 text-center p-4">
                            <i class="fas fa-flask fa-2x text-info mb-3"></i>
                            <h5 class="fw-bold mb-2">وحدة البحوث</h5>
                            <p class="text-muted">إدارة مقترحات البحوث، التعليقات، والتقييمات للمشاريع الطلابية.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 text-center p-4">
                            <i class="fas fa-users fa-2x text-warning mb-3"></i>
                            <h5 class="fw-bold mb-2">المستخدمون والصلاحيات</h5>
                            <p class="text-muted">إنشاء مستخدمين جدد وتخصيص صلاحيات دقيقة لكل دور.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tech Stack Section --}}
        <section class="py-5" id="tech">
            <div class="container text-center">
                <h2 class="h1 mb-4">التقنيات المستخدمة</h2>
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-4">
                    @php
                        $techs = [
                            'laravel'   => 'Laravel',
                            'php'       => 'PHP',
                            'bootstrap' => 'Bootstrap',
                            'mysql'     => 'MySQL',
                            'vue'       => 'Vue.js',
                        ];
                    @endphp
                    @foreach($techs as $file => $label)
                        <div class="tech-item text-center">
                            @php
                                $logoPath = public_path("images/logos/{$file}.svg");
                                $appIcons = [
                                    'laravel'   => 'fab fa-laravel',
                                    'php'       => 'fab fa-php',
                                    'bootstrap' => 'fab fa-bootstrap',
                                    'mysql'     => 'fas fa-database',
                                    'vue'       => 'fab fa-vuejs',
                                ];
                                $iconClass = $appIcons[$file] ?? 'fas fa-code';
                            @endphp
                            @if(file_exists($logoPath))
                                <img src="{{ asset("images/logos/{$file}.svg") }}"
                                     alt="{{ $label }}" class="img-fluid" style="height:60px;">
                            @else
                                <i class="{{ $iconClass }} fa-3x"></i>
                            @endif
                            <p class="mt-2 mb-0">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Team Section --}}
        <section class="bg-light py-5" id="team">
            <div class="container">
                <h2 class="h1 text-center mb-5">فريق التطوير</h2>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('images/team/1.jpg') }}" class="rounded-circle mb-3" width="120" alt="Alex">
                        <h6 class="fw-bold mb-1">جعفر وفقان</h6>
                        <p class="text-muted">مطوّر Full Stack</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('images/team/2.jpg') }}" class="rounded-circle mb-3" width="120" alt="Layla">
                        <h6 class="fw-bold mb-1">اسامة المولى</h6>
                        <p class="text-muted">مصممة واجهات</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('images/team/3.jpg') }}" class="rounded-circle mb-3" width="120" alt="Khaled">
                        <h6 class="fw-bold mb-1">رسل علي</h6>
                        <p class="text-muted">مهندس قاعدة بيانات</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Contact Section --}}
        <section id="contact" class="py-5">
            <div class="container">
                <h2 class="text-center mb-4 text-dark">تواصل معنا</h2>
                <div class="card mx-auto shadow-sm" style="max-width: 800px;">
                    <div class="card-body p-4">
                        <form class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" id="contactName" class="form-control" placeholder="اسمك">
                                    <label for="contactName">اسمك</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" id="contactEmail" class="form-control" placeholder="بريدك الإلكتروني">
                                    <label for="contactEmail">بريدك الإلكتروني</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea id="contactMessage" class="form-control" placeholder="رسالتك" style="height: 150px;"></textarea>
                                    <label for="contactMessage">رسالتك</label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg mt-3">
                                    <i class="fas fa-paper-plane me-2"></i>إرسال
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('styles')
        <style>
            /* إزالة خلفيات الأقسام */
            .hero, section, #overview, #features, #tech, #team, #contact { background: transparent !important; padding: 60px 0; }
            .container-fluid p-0 { padding: 0; }
            /* تفعيل البطاقات */
            .card, .feature-card, .stat-card {
                background: #fff !important;
                border-radius: 12px;
                box-shadow: 0 6px 18px rgba(0,0,0,0.08);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                margin-bottom: 2rem;
            }
            .card:hover, .feature-card:hover, .stat-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
            }
            /* تنسيق الأيقونات داخل البطاقات */
            .feature-card .feature-icon,
            .stat-card .feature-icon {
                width: 80px;
                height: 80px;
                background: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                margin: 0 auto 1rem;
            }
            /* إزالة الهوامش الصلبة */
            section h2, section h3, section h1 {
                margin-bottom: 1.5rem;
            }
            /* الكروت التفاعلية */
            .btn, .btn-lg {
                border-radius: 8px;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .btn:hover, .btn-lg:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            }
            /* إزالة أكواد الخلفية القديمة */
            .hero { background-image: none !important; }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Smooth scroll
                document.querySelectorAll('a[href^="#"]').forEach(a => {
                    a.addEventListener('click', e => {
                        e.preventDefault();
                        document.querySelector(a.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
                    });
                });
            });
        </script>
    @endpush

@endsection
