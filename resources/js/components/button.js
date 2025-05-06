// button.js - وظائف بسيطة للأزرار الموحدة

document.addEventListener('DOMContentLoaded', function () {
    // مثال: تأكيد الحذف لجميع الأزرار التي تحمل data-confirm
    document.querySelectorAll('button[data-confirm], a[data-confirm]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!confirm(btn.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });
}); 