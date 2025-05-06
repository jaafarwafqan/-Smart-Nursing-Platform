<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Student::with('branch')->get();
    }

    public function headings(): array
    {
        return [
            'الرقم',
            'الاسم',
            'البريد الإلكتروني',
            'رقم الهاتف',
            'الفرع',
            'رقم الطالب',
            'تاريخ التسجيل',
            'سنة التخرج المتوقعة',
            'تاريخ الإنشاء',
            'تاريخ التحديث'
        ];
    }

    public function map($student): array
    {
        return [
            $student->id,
            $student->name,
            $student->email,
            $student->phone,
            $student->branch->name ?? '',
            $student->student_id,
            $student->enrollment_date,
            $student->graduation_year,
            $student->created_at,
            $student->updated_at
        ];
    }
} 