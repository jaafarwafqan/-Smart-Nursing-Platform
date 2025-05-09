<?php
namespace App\Imports;

use App\Models\Professor;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProfessorsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // تطبيع قيمة الجنس
        $gender = trim($row['gender']);
        if ($gender === 'انثى' || $gender === 'أنثى') {
            $gender = 'انثى';
        } else {
            $gender = 'ذكر';
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

    public function rules(): array
    {
        return [
            'name'   => 'required|string',
            'gender' => 'required|in:ذكر,انثى',
            'email'  => 'nullable|email',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'gender.in' => 'حقل الجنس يجب أن يكون "ذكر" أو "انثى".',
            'name.required' => 'اسم الأستاذ مطلوب.',
        ];
    }
}
