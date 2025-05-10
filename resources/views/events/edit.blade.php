@extends('layouts.app')
@section('title', 'تعديل فعالية')

@section('content')
    <form action="{{ route('events.update', $event) }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        @include('events._form', ['branches' => $branches])
        <x-file-upload name="attachments[]" :current-files="$event->attachments->pluck('path')->toArray()" :delete-route="'events.attachment.destroy'" :model-id="$event->id" />
    </form>
@endsection
