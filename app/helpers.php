<?php

/*==================================================
| روابط الفرز الجدولية
==================================================*/
if (! function_exists('sort_link')) {
    /**
     * أنشئ رابط فرز لعمود جدول.
     */
    function sort_link(string $label, string $column): string
    {
        $request        = request();
        $currentColumn  = $request->get('sort_by');
        $direction      = $request->get('sort_dir', 'asc');

        // عكس الاتجاه إذا كان نفس العمود مفعَّلًا
        $newDirection = ($currentColumn === $column && $direction === 'asc') ? 'desc' : 'asc';

        // توليد الرابط
        $url = $request->fullUrlWithQuery([
            'sort_by'  => $column,
            'sort_dir' => $newDirection,
        ]);

        // أيقونة
        $icon = '<i class="fas fa-sort ms-1 text-muted"></i>';
        if ($currentColumn === $column) {
            $icon = $direction === 'asc'
                ? '<i class="fas fa-sort-up ms-1"></i>'
                : '<i class="fas fa-sort-down ms-1"></i>';
        }

        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} {$icon}</a>";
    }
}

/*==================================================
| تنسيق التاريخ
==================================================*/
if (! function_exists('format_date')) {
    function format_date(?string $date, string $format = 'Y-m-d'): ?string
    {
        return $date ? date($format, strtotime($date)) : null;
    }
}

/*==================================================
| نوع الملف + أيقونته
==================================================*/
if (! function_exists('get_file_type')) {
    function get_file_type(string $filename): string
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $images    = ['jpg','jpeg','png','gif','bmp','svg','webp'];
        $documents = ['pdf','doc','docx','xls','xlsx','ppt','pptx','txt'];

        return in_array($ext, $images)     ? 'image'
            : (in_array($ext, $documents) ? 'document' : 'other');
    }
}

if (! function_exists('get_file_icon')) {
    function get_file_icon(string $filename): string
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return [
            'pdf'  => 'fa-file-pdf',
            'doc'  => 'fa-file-word',   'docx' => 'fa-file-word',
            'xls'  => 'fa-file-excel',  'xlsx' => 'fa-file-excel',
            'ppt'  => 'fa-file-powerpoint','pptx'=>'fa-file-powerpoint',
            'jpg'  => 'fa-file-image',  'jpeg' => 'fa-file-image',
            'png'  => 'fa-file-image',  'gif'  => 'fa-file-image',
            'txt'  => 'fa-file-lines',
        ][$ext] ?? 'fa-file';
    }
}

/*==================================================
| حجم الملف بصيغة مقروءة
==================================================*/
if (! function_exists('format_file_size')) {
    function format_file_size(int $bytes): string
    {
        $units = ['B','KB','MB','GB','TB'];
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2).' '.$units[$i];
    }
}

/*==================================================
| ترجمة صلاحية Spatie إلى العربية
==================================================*/
if (! function_exists('translate_permission')) {
    function translate_permission(string $permission): string
    {
        return [
            'manage_campaigns'   => 'إدارة الحملات',
            'manage_events'      => 'إدارة الفعاليات',
            'manage_researches'  => 'إدارة الأبحاث',
            'manage_proposals'   => 'إدارة المقترحات',
            'manage_users'       => 'إدارة المستخدمين',
            'manage_reports'     => 'إدارة التقارير',
            'system_admin'       => 'مدير النظام',
        ][$permission] ?? $permission;
    }
}
