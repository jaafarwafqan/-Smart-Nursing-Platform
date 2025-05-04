@extends('layouts.app')
@section('title', 'تعديل حملة')
@section('content')
    <form action="{{ route('campaigns.update', $campaign) }}"
          method="post"
          enctype="multipart/form-data"
          class="needs-validation"
          novalidate>
        @csrf
        @method('PUT')
        {{-- تمرير المتغيّر $branches إلى الـPartial --}}
        @include('campaigns._form', ['branches' => $branches])
    </form>
@endsection
