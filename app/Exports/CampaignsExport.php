<?php

namespace App\Exports;

use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Campaign::all();
    }

    public function headings(): array
    {
        return [
            'رقم الحملة',

            'اسم الحملة',
            'تاريخ البدء',
            'تاريخ الانتهاء',
            'المنظمون',
            'المشاركون',
            'الفرع',
            'التفاصيل',
            'المرفقات',
            'أنشئ في',
            'تم التحديث في'
        ];
    }
}
