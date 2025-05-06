<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TeachersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Teacher::with('branch')->get();
    }

    public function headings(): array
    {
        return [
            'الرقم',
            'الاسم',
            'البريد الإلكتروني',
            'رقم الهاتف',
            'الفرع',
            'التخصص',
            'الرتبة الأكاديمية',
            'تاريخ التعيين',
            'تاريخ الإنشاء',
            'تاريخ التحديث'
        ];
    }

    public function map($teacher): array
    {
        return [
            $teacher->id,
            $teacher->name,
            $teacher->email,
            $teacher->phone,
            $teacher->branch->name ?? '',
            $teacher->specialization,
            $teacher->academic_rank,
            $teacher->hire_date,
            $teacher->created_at,
            $teacher->updated_at
        ];
    }
} 