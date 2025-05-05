import './bootstrap';
import $ from 'jquery';
import 'datatables.net-bs5';
import arLang from 'datatables.net-plugins/i18n/ar.json';

// (1) إعداد الافتراضيات
$.extend(true, $.fn.dataTable.defaults, {
    language: arLang,
    searching: false,
    lengthChange: true,
    pageLength: 10,
    dom: '<"top">rt<"d-flex justify-content-between align-items-center p-2"lip>'
});

// (2) نفّذ التهيئة بعد تحميل DOM
document.addEventListener('DOMContentLoaded', () => {
    // DataTables
    $('.datatable').DataTable({
        paging: true,
        ordering: true,
        info: true,
        order: [[3, 'desc']],
        columnDefs: [
            { targets: 0, searchable: false, orderable: false, render: (d, t, r, m) => m.row + 1 },
            { targets: [6,7], searchable: false, orderable: false }
        ]
    });

    // Tooltips & Popovers
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));
    document.querySelectorAll('[data-bs-toggle="popover"]')
        .forEach(el => new bootstrap.Popover(el));

    // عرض اسم الملف عند اختيار file
    document.querySelectorAll('.form-control[type="file"]').forEach(input => {
        input.addEventListener('change', () => {
            const lbl = input.nextElementSibling;
            if (lbl?.tagName.toLowerCase() === 'label') {
                lbl.textContent = input.files[0]?.name || 'اختر ملفاً';
            }
        });
    });
});
