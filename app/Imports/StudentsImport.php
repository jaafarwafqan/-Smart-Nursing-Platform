<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $name = $row['name'] ?? $row['الاسم'] ?? null;
        $gender = $row['gender'] ?? $row['الجنس'] ?? null;
        $study_type = $row['study_type'] ?? $row['نوع الدراسة'] ?? $row['نوع_الدراسة'] ?? null;

        // تجاهل الصف إذا لم يوجد اسم أو جنس أو نوع دراسة
        if (!$name || !$gender || !$study_type) {
            return null;
        }

        return new Student([
            'name' => $name,
            'gender' => $gender,
            'birthdate' => $row['birthdate'] ?? $row['تاريخ الميلاد'] ?? $row['تاريخ_الميلاد'] ?? null,
            'university_number' => $row['university_number'] ?? $row['الرقم الجامعي'] ?? $row['الرقم_الجامعي'] ?? null,
            'study_type' => $study_type,
            'study_year' => $row['study_year'] ?? $row['سنة الدراسة'] ?? $row['سنة_الدراسة'] ?? null,
            'program' => $row['program'] ?? $row['البرنامج'] ?? null,
            'phone' => $row['phone'] ?? $row['الهاتف'] ?? null,
            'email' => $row['email'] ?? $row['البريد الإلكتروني'] ?? $row['البريد_الإلكتروني'] ?? null,
            'notes' => $row['notes'] ?? $row['ملاحظات'] ?? null,
        ]);
    }
} 