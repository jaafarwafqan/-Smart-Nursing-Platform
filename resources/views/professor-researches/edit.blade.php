@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">تعديل بحث أستاذ</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('professor-researches.update', $professorResearch) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('professor-researches._form', [
                            'research' => $professorResearch,
                            'branches' => $branches ?? [],
                            'professors' => $professors ?? [],
                            'journals' => $journals ?? [],
                            'selectedProfessors' => $professorResearch->professors ?? [],
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // تهيئة Select2
    $('.select2').select2();

    // إضافة أستاذ جديد
    $('#add-professor').click(function() {
        var newRow = $('.professor-row:first').clone();
        newRow.find('select').val('');
        newRow.find('input').val('');
        newRow.find('.remove-professor').show();
        $('#professors-container').append(newRow);
    });

    // حذف أستاذ
    $(document).on('click', '.remove-professor', function() {
        $(this).closest('.professor-row').remove();
    });
});
</script>
@endpush 