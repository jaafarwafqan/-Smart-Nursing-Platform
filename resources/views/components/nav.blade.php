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
                @can('manage_users')
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">المستخدمون</a></li>
                @endcan
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">حول النظام</a></li>
            </ul>

            {{-- معلومات الحساب / الدخول --}}
            <ul class="navbar-nav align-items-lg-center gap-lg-2">
                @auth
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-user-circle me-1"></i>{{ Str::limit(Auth::user()->name, 20) }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-link nav-link p-0">خروج</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">دخول</a></li>
                @endauth
            </ul>

        </div>
    </div>
</nav>
