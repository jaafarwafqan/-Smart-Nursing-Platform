@extends('layouts.app')
@section('title', 'إضافة حملة  ')
@section('content')
    <div class="mb-4 text-center">
        <h2 class="fw-bold"><i class="fas fa-bullhorn text-success ms-2"></i> إضافة حملة</h2>
    </div>
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
