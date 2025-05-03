<?php
namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatisticsExport implements FromCollection, WithHeadings
{
    protected $statistics;

    public function __construct($statistics)
    {
        $this->statistics = $statistics;
    }

    public function collection()
    {
        return collect($this->statistics)->map(function ($stat) {
            return [
                'الفرع' => $stat['branch'],
                'عدد الفعاليات' => $stat['events_total'],
                'عدد الحملات' => $stat['campaigns_total'],
                'الحملات الجارية' => $stat['active_campaigns'] ?? 0,
                'الحملات المكتملة' => $stat['completed_campaigns'] ?? 0,
                'الحملات المخطط لها' => $stat['planned_campaigns'] ?? 0,
                'إجمالي المشاركين في الحملات' => $stat['total_campaign_participants'] ?? 0,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'الفرع',
            'عدد الفعاليات',
            'عدد الحملات',
            'الحملات الجارية',
            'الحملات المكتملة',
            'الحملات المخطط لها',
            'إجمالي المشاركين في الحملات'
        ];
    }
}
