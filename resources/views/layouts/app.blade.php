<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title','منصة التمريص الذكية')</title>

    @vite(['resources/scss/app.scss','resources/js/app.js'])
    @stack('styles')
    {{-- Font Awesome 6 (CDN) --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          integrity="sha512-…"
          crossorigin="anonymous" referrerpolicy="no-referrer" />
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
