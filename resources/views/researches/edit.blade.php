@extends('layouts.app')
@section('title','تعديل بحث')

@section('content')
    <h1 class="h4 mb-4">تعديل البحث: {{ $research->research_title }}</h1>

    <form action="{{ route('researches.update', $research) }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        <x-researches.form :research="$research" :branches="$branches"/>
    </form>
@endsection
