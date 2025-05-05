<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // ➤ 1) تطبيع الجنس
        $gender = trim($row['gender']);
        if ($gender === 'انثى') {       // بدون همزة
            $gender = 'انثى';
        } elseif ($gender !== 'ذكر') {
            // بدلًا من رمي خطأ null، يمكنك افتراض ذكر أو تجاهل الصف
            $gender = 'ذكر';
        }

        // ➤ 2) تطبيع نوع الدراسة
        $rawType = trim($row['study_type']);
        $studyType = match ($rawType) {
            'اولية', 'أولية'    => 'أولية',
            'ماجستير'           => 'ماجستير',
            'دكتوراه'           => 'دكتوراه',
            default             => null,
        };

        // ➤ 3) معالجة تاريخ الميلاد
        $birthRaw = trim($row['birthdate']);

        if (is_numeric($birthRaw)) {
            // إن كان رقم Excel Serial
            $birthdate = ExcelDate::excelToDateTimeObject($birthRaw)->format('Y-m-d');
        } elseif (strpos($birthRaw, '\\') !== false) {
            // إن كانت بصيغة "YYYY\MM\DD"
            $birthdate = Carbon::parse(str_replace('\\','/',$birthRaw))->format('Y-m-d');
        } elseif ($birthRaw) {
            // أي صيغة أخرى صالحة
            $birthdate = Carbon::parse($birthRaw)->format('Y-m-d');
        } else {
            $birthdate = null;
        }

        return new Student([
            'name'             => $row['name'],
            'gender'           => $gender,
            'birthdate'        => isset($row['birthdate']) ? Carbon::parse($row['birthdate']) : null,
            'university_number'=> $row['university_number'] ?: null,
            'study_type'       => $row['study_type'],
            'study_year'       => $row['study_year'] ?: null,
            'program'          => $row['program'] ?: null,
            'phone'            => $row['phone'] ?: null,
            'email'            => $row['email'] ?: null,
            'notes'            => $row['notes'] ?: null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string',
            'gender'            => 'required|in:ذكر,انثى',
            'university_number' => 'required|unique:students,university_number',
            'study_type'        => 'required|in:أولية,ماجستير,دكتوراه',
            'email'             => 'nullable|email',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'gender.in'     => 'حقل الجنس يجب أن يكون "ذكر" أو "انثى".',
            'study_type.in' => 'حقل نوع الدراسة يجب أن يكون "أولية" أو "ماجستير" أو "دكتوراه".',
        ];
    }
}
