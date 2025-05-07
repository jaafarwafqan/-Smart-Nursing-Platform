<?php

namespace App\Exports;

use App\Models\Research;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResearchesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Research::with(['students', 'professors', 'journals'])->get()->map(function ($research) {
            return [
                'ID' => $research->id,
                'العنوان' => $research->title,
                'نوع البحث' => Research::getResearchTypes()[$research->research_type] ?? $research->research_type,
                'تاريخ البدء' => $research->start_date,
                'تاريخ الانتهاء' => $research->end_date,
                'الحالة' => Research::getStatuses()[$research->status] ?? $research->status,
                'حالة النشر' => Research::getPublicationStatuses()[$research->publication_status] ?? $research->publication_status,
                'نسبة الإنجاز' => $research->completion_percentage . '%',
                'الوصف' => $research->description,
                'الملخص' => $research->abstract,
                'الكلمات المفتاحية' => $research->keywords,
                'ملاحظات' => $research->notes,
                'الطلاب' => $research->students->pluck('name')->implode(', '),
                'الأساتذة' => $research->professors->pluck('name')->implode(', '),
                'المجلات' => $research->journals->pluck('name')->implode(', '),
                'المسار الكامل للملف' => $research->file_path,
                'تاريخ الإنشاء' => $research->created_at,
                'تاريخ التحديث' => $research->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'العنوان',
            'نوع البحث',
            'تاريخ البدء',
            'تاريخ الانتهاء',
            'الحالة',
            'حالة النشر',
            'نسبة الإنجاز',
            'الوصف',
            'الملخص',
            'الكلمات المفتاحية',
            'ملاحظات',
            'الطلاب',
            'الأساتذة',
            'المجلات',
            'المسار الكامل للملف',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
        ];
    }
} 