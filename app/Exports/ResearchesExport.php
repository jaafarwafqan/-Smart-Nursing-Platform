<?php

namespace App\Exports;

use App\Models\Research;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResearchesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Research::with(['students', 'professors'])->get()->map(function ($research) {
            return [
                'ID' => $research->id,
                'العنوان' => $research->title,
                'النوع' => $research->research_type,
                'تاريخ البدء' => $research->start_date,
                'تاريخ الانتهاء' => $research->end_date,
                'الحالة' => $research->status,
                'الوصف' => $research->description,
                'الملخص' => $research->abstract,
                'الكلمات المفتاحية' => $research->keywords,
                'ملاحظات' => $research->notes,
                'الطلاب' => $research->students->pluck('name')->implode(', '),
                'الأساتذة' => $research->professors->pluck('name')->implode(', '),
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
            'النوع',
            'تاريخ البدء',
            'تاريخ الانتهاء',
            'الحالة',
            'الوصف',
            'الملخص',
            'الكلمات المفتاحية',
            'ملاحظات',
            'الطلاب',
            'الأساتذة',
            'المسار الكامل للملف',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
        ];
    }
} 