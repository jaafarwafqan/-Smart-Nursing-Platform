@extends('layouts.app')
@section('title', 'إضافة فعالية')

@section('content')
    <div class="mb-4 text-center">
        <h2 class="fw-bold"><i class="fas fa-calendar-check text-primary ms-2"></i> إضافة فعالية</h2>
    </div>
    <form action="{{ route('events.store') }}"
          method="post"
          enctype="multipart/form-data"
          class="needs-validation"
          novalidate>

        @csrf
        {{-- تمرير المتغيّر $branches و $event و $eventTypes إلى الـPartial --}}
        @include('events._form', ['branches' => $branches, 'event' => null, 'eventTypes' => $eventTypes])



    </form>

@endsection
