<?php

namespace App\Exports;

use App\Models\Professor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProfessorsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Professor::with(['researches', 'professorResearches'])->get()->map(function ($professor) {
            return [
                'ID' => $professor->id,
                'الاسم' => $professor->name,
                'الجنس' => $professor->gender,
                'الرتبة الأكاديمية' => $professor->academic_rank,
                'الكلية' => $professor->college,
                'القسم' => $professor->department,
                'مجالات البحث' => $professor->research_interests,
                'رقم الهاتف' => $professor->phone,
                'البريد الإلكتروني' => $professor->email,
                'ملاحظات' => $professor->notes,
                'عدد البحوث' => $professor->researches->count(),
                'عدد بحوث الأساتذة' => $professor->professorResearches->count(),
                'تاريخ الإنشاء' => $professor->created_at,
                'تاريخ التحديث' => $professor->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'الاسم',
            'الجنس',
            'الرتبة الأكاديمية',
            'الكلية',
            'القسم',
            'مجالات البحث',
            'رقم الهاتف',
            'البريد الإلكتروني',
            'ملاحظات',
            'عدد البحوث',
            'عدد بحوث الأساتذة',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
        ];
    }
} 