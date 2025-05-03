@extends('layouts.app')
@section('title', 'إضافة فعالية')

@section('content')
    <form action="{{ route('events.store') }}"
          method="post"
          enctype="multipart/form-data"
          class="needs-validation"
          novalidate>

        @csrf
        {{-- تمرير المتغيّر $branches إلى الـPartial --}}
        @include('events._form', ['branches' => $branches])

    </form>

@endsection
