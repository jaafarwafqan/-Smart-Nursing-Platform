<?php

namespace App\Exports;

use App\Models\Event;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
};

class EventsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * جلب بيانات الفعاليات وفق صلاحيات المستخدم.
     */
    public function collection(): Collection
    {
        $user   = Auth::user();
        $events = Event::with('branch')      // eager‑load الفرع
        ->orderBy('event_datetime', 'desc');

        // المستخدم غير أدمن ⇒ يقيَّد بفرعه
        if ($user && ! $user->is_admin) {
            $events->where('branch_id', $user->branch_id);
        }

        return $events->get();
    }

    /**
     * رؤوس الأعمدة في ملف Excel.
     */
    public function headings(): array
    {
        return [
            'التسلسل',
            'نوع الفعالية',
            'عنوان الفعالية',
            'التاريخ والوقت',
            'الموقع',
            'الفرع',
            'المحاضرون',
            'عدد الحضور',
            'المدة (ساعات)',
            'الوصف',
            'الحالة',
        ];
    }

    /**
     * تمثيل كل سطر (Event) في ملف Excel.
     */
    public function map($event): array
    {
        // معالجة المحاضرين (قد يكون مصفوفة أو نصًا)
        $lecturers = is_array($event->lecturers)
            ? implode(', ', $event->lecturers)
            : ($event->lecturers ?? '—');

        return [
            $event->id,
            $event->event_type,
            $event->event_title,
            $event->event_datetime->format('Y-m-d H:i'),
            $event->location,
            $event->branch?->name ?? '—',
            $lecturers,
            $event->attendance,
            $event->duration,
            $event->description,
            $event->status_text ?? '—',
        ];
    }
}
