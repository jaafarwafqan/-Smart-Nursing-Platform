<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - منصة التمريض الذكية</title>
    <link rel="icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

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
