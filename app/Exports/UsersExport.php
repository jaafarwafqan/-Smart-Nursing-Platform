<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with('permissions', 'branch')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'الاسم',
            'البريد الإلكتروني',
            'الفرع',
            'نوع المستخدم',
            'الصلاحيات',
            'تاريخ الإنشاء',
            'آخر تحديث'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->branch?->name ?? 'غير محدد',
            $this->getUserType($user->type),
            $user->permissions->pluck('name')->implode(', '),
            $user->created_at?->format('Y-m-d H:i:s') ?? 'N/A',
            $user->updated_at?->format('Y-m-d H:i:s') ?? 'N/A',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Get user type in Arabic
     */
    private function getUserType($type): string
    {
        return match ($type) {
            'admin'    => 'مدير النظام',
            'faculty'  => 'تدريسي',
            'student'  => 'طالب',
            'employee' => 'موظف',
            default    => 'غير معروف',
        };
    }
}
