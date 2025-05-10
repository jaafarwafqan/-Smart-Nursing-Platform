<?php

namespace App\Exports;

use App\Models\Journal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JournalsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Journal::with(['professorResearches'])->get()->map(function ($journal) {
            return [
                'ID' => $journal->id,
                'اسم الدورية' => $journal->name,
                'نوع الدورية' => $journal->type,
                'مفهرسة في Scopus' => $journal->is_scopus_indexed ? 'نعم' : 'لا',
                'مفهرسة في Clarivate' => $journal->is_clarivate_indexed ? 'نعم' : 'لا',
                'الموقع الإلكتروني' => $journal->website,
                'ملاحظات' => $journal->notes,
                'عدد البحوث المنشورة' => $journal->professorResearches->count(),
                'تاريخ الإنشاء' => $journal->created_at,
                'تاريخ التحديث' => $journal->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'اسم الدورية',
            'نوع الدورية',
            'مفهرسة في Scopus',
            'مفهرسة في Clarivate',
            'الموقع الإلكتروني',
            'ملاحظات',
            'عدد البحوث المنشورة',
            'تاريخ الإنشاء',
            'تاريخ التحديث',
        ];
    }
} 