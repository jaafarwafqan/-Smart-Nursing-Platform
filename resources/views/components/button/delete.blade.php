@props(['action', 'user'])

<div>
    {{-- نموذج الحذف --}}
    <x-modal id="deleteModal{{ $user->id }}" title="تأكيد الحذف" :action="$action" method="DELETE">
        <p>هل أنت متأكد أنك تريد حذف المستخدم "{{ $user->name }}"؟</p>
    </x-modal>

</div>
