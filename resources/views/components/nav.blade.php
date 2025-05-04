<nav class="navbar navbar-expand-lg navbar-smart fixed-top navbar-dark">
    <div class="container-fluid">

        {{-- الشعار – يظهر يميناً مع RTL --}}
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('images/شعار الكلية.png') }}" alt="Logo" width="30" height="30"
                 class="d-inline-block align-text-top">
            منصة التمريض الذكية
        </a>


        {{-- زر الطيّ للشاشات الصغيرة --}}
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            {{-- الروابط الرئيسة --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-2">
                @can('manage_events')
                    <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">الفعاليات</a></li>
                @endcan
                @can('manage_campaigns')
                    <li class="nav-item"><a class="nav-link" href="{{ route('campaigns.index') }}">الحملات</a></li>
                @endcan
                @can('manage_researches')
                    <li class="nav-item"><a class="nav-link" href="{{ route('researches.index') }}">البحوث</a></li>
                @endcan
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard.index') }}">التقارير</a></li>
                @can('manage_users')
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">المستخدمون</a></li>
                @endcan
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">حول النظام</a></li>
            </ul>

            {{-- معلومات الحساب / الدخول --}}
            {{-- القائمة اليمنى --}}
            <ul class="navbar-nav">

                @auth
                    {{-- قائمة منسدلة للمستخدم --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Str::limit(Auth::user()->name, 15) }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end text-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-1"></i> ملفي الشخصي
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-1"></i> خروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> دخول
                        </a>
                    </li>
                @endauth
            </ul>


        </div>
    </div>
</nav>
