@extends('layouts.app')
@section('title', 'إضافة حملة  ')
@section('content')
    <form action="{{ route('campaigns.store') }}"
          method="post"
          enctype="multipart/form-data"
          class="needs-validation"
          novalidate>
        @csrf
        {{-- تمرير المتغيّر $branches إلى الـPartial --}}
        @include('campaigns._form', ['branches' => $branches])
    </form>
@endsection
