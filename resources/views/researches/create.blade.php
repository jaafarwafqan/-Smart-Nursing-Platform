@extends('layouts.app')
@section('title','إضافة بحث')

@section('content')
    <h1 class="h4 mb-4">إضافة بحث جديد</h1>

    <form action="{{ route('researches.store') }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <x-researches.form :branches="$branches"/>
    </form>
@endsection
