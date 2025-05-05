<?php
namespace App\Imports;

use App\Models\Professor;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProfessorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // تطبيع قيمة الجنس
        $gender = trim($row['gender']);
        if ($gender === 'انثى') {
            $gender = 'أنثى';
        } elseif ($gender !== 'ذكر' && $gender !== 'نثى') {
            $gender = null;
        }

        return new Professor([
            'name'      => $row['name'],
            'gender'    => $gender,
            'academic_rank' => $row['academic_rank'] ?? null,
            'college'   => $row['college'] ?? null,
            'department' => $row['department'] ?? null,
            'research_interests' => $row['research_interests'] ?? null,
            'phone'     => $row['phone'] ?? null,
            'email'     => $row['email'] ?? null,
            'notes'     => $row['notes'] ?? null,
        ]);
    }
}
