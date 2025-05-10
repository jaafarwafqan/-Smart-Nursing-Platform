<?php

namespace App\Services;

use App\Contracts\ProfessorServiceInterface;
use App\Models\Professor;
use Illuminate\Support\Facades\DB;

class ProfessorService implements ProfessorServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): Professor
    {
        return DB::transaction(function () use ($data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $professor = Professor::create($data);

            foreach ($attachments as $file) {
                $professor->attachments()->create([
                    'path' => $this->files->store($file, 'professors'),
                ]);
            }

            return $professor;
        });
    }

    public function update(Professor $professor, array $data): bool
    {
        return DB::transaction(function () use ($professor, $data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $professor->update($data);

            foreach ($attachments as $file) {
                $professor->attachments()->create([
                    'path' => $this->files->store($file, 'professors'),
                ]);
            }

            return true;
        });
    }

    public function delete(Professor $professor): bool
    {
        return DB::transaction(function () use ($professor) {
            foreach ($professor->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $professor->delete();
        });
    }
} 