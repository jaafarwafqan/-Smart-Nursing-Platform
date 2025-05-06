<?php

namespace App\Services;

use App\Contracts\StudentServiceInterface;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService implements StudentServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): Student
    {
        return DB::transaction(function () use ($data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $student = Student::create($data);

            foreach ($attachments as $file) {
                $student->attachments()->create([
                    'path' => $this->files->store($file, 'students'),
                ]);
            }

            return $student;
        });
    }

    public function update(Student $student, array $data): bool
    {
        return DB::transaction(function () use ($student, $data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $student->update($data);

            foreach ($attachments as $file) {
                $student->attachments()->create([
                    'path' => $this->files->store($file, 'students'),
                ]);
            }

            return true;
        });
    }

    public function delete(Student $student): bool
    {
        return DB::transaction(function () use ($student) {
            foreach ($student->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $student->delete();
        });
    }
} 