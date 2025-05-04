@extends('layouts.app')
@section('title','إضافة بحث')

@section('content')
    <form action="{{ route('researches.store') }}"
          method="post"
          enctype="multipart/form-data"
          class="needs-validation"
          novalidate>
        @csrf
        {{-- تمرير المتغيّر $branches إلى الـPartial --}}
        @include('researches._form', ['branches' => $branches])
    </form>
@endsection
