<?php

namespace App\Exports;

use App\Models\ProfessorResearch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfessorResearchesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ProfessorResearch::with(['professor', 'journal'])->get()->map(function ($research) {
            return [
                'ID' => $research->id,
                'عنوان البحث' => $research->title,
                'نوع البحث' => $research->research_type,
                'تاريخ البدء' => $research->start_date,
                'تاريخ الانتهاء' => $research->end_date,
                'حالة النشر' => $research->publication_status,
                'نسبة الإنجاز' => $research->completion_percentage,
                'الملخص' => $research->abstract,
                'الكلمات المفتاحية' => $research->keywords,
                'ملاحظات' => $research->notes,
                'الأستاذ' => $research->professor->name,
                'الدورية' => $research->journal ? $research->journal->name : 'غير محدد',
                'تاريخ الإنشاء' => $research->created_at,
                'تاريخ التحديث' => $research->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'عنوان البحث',
            'نوع البحث',
            'تاريخ البدء',
            'تاريخ الانتهاء',
            'حالة النشر',
            'نسبة الإنجاز',
            'الملخص',
            'الكلمات المفتاحية',
            'ملاحظات',
            'الأستاذ',
            'الدورية',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
        ];
    }
} 