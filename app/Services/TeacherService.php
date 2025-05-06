<?php

namespace App\Services;

use App\Contracts\TeacherServiceInterface;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherService implements TeacherServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): Teacher
    {
        return DB::transaction(function () use ($data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $teacher = Teacher::create($data);

            foreach ($attachments as $file) {
                $teacher->attachments()->create([
                    'path' => $this->files->store($file, 'teachers'),
                ]);
            }

            return $teacher;
        });
    }

    public function update(Teacher $teacher, array $data): bool
    {
        return DB::transaction(function () use ($teacher, $data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $teacher->update($data);

            foreach ($attachments as $file) {
                $teacher->attachments()->create([
                    'path' => $this->files->store($file, 'teachers'),
                ]);
            }

            return true;
        });
    }

    public function delete(Teacher $teacher): bool
    {
        return DB::transaction(function () use ($teacher) {
            foreach ($teacher->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $teacher->delete();
        });
    }
} 