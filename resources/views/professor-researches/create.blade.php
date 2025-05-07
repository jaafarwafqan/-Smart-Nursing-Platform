@extends('layouts.app')
@section('title','إضافة بحث أستاذ')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">إضافة بحث أستاذ جديد</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('professor-researches.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('professor-researches._form', [
                            'research' => null,
                            'branches' => $branches ?? [],
                            'professors' => $professors ?? [],
                            'journals' => $journals ?? [],
                            'selectedProfessors' => [],
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 