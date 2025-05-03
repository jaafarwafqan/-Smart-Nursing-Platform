@extends('layouts.app')
@section('title', 'تعديل فعالية')

@section('content')
    <form action="{{ route('events.update', $event) }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        @include('events._form', ['branches' => $branches])
    </form>
@endsection
