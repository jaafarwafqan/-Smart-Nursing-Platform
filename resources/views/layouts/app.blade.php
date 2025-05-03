<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title','منصة التمريص الذكية')</title>

    @vite(['resources/scss/app.scss','resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-light">

<x-nav/>

<main class="container py-4">
    @include('partials.alerts') {{-- رسائل success / error --}}
    @yield('content')
</main>

<x-footer/>
@stack('scripts')
</body>
</html>
