@extends('layouts.app')
@section('title','تعديل بحث')

@section('content')
    <form action="{{ route('researches.update', $research) }}"
          method="post"
          enctype="multipart/form-data"
          class="needs-validation"
          novalidate>
        @csrf
        @method('PUT')
        {{-- تمرير المتغيّر $branches إلى الـPartial --}}
        @include('researches._form', ['branches' => $branches])
    </form>

@endsection
