/**
 * resources/js/app.js
 * – يستورد bootstrap.bundle (يشمل Popper وBootstrap JS) و axios
 * – يهيّئ DataTables عالمياً
 * – يفعّل Tooltips/Popovers
 * – حدثُ عرض اسم الملف في حقول type="file"
 */

import './bootstrap';                     // axios + bootstrap.bundle
import $ from 'jquery';
import 'datatables.net-bs5';              // DataTables JS
 // DataTables CSS من NPM
import arLang from 'datatables.net-plugins/i18n/ar.json';      // ترجمة عربية

// إعدادات DataTables عامة
$.extend(true, $.fn.dataTable.defaults, {
    language    : arLang,
    searching   : false,
    lengthChange: true,
    pageLength  : 10,
    dom         : '<"top">rt<"d-flex justify-content-between align-items-center p-2"lip>'
});

// فعّل على أي جدول بصنف datatable
$('.datatable').DataTable({
    paging: true,
    ordering: true,
    info: true,
    order: [[3, 'desc']],
    columnDefs: [
        {
            targets: 0,           // رقم العمود الوحيد الذي تريد ترقيمه
            searchable: false,
            orderable: false,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            targets: [6, 7],
            searchable: false,
            orderable: false
        }
    ]

});

// باقي الإعدادات عند تحميل DOM
document.addEventListener('DOMContentLoaded', () => {
    // Tooltips & Popovers
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(el => new bootstrap.Tooltip(el));
    document.querySelectorAll('[data-bs-toggle="popover"]')
        .forEach(el => new bootstrap.Popover(el));

    // عرض اسم الملف عند تغييره
    document.querySelectorAll('.form-control[type="file"]').forEach(input => {
        input.addEventListener('change', () => {
            const label = input.nextElementSibling;
            if (label && label.tagName.toLowerCase() === 'label') {
                label.textContent = input.files.length
                    ? input.files[0].name
                    : 'اختر ملفاً';
            }
        });
    });
});
