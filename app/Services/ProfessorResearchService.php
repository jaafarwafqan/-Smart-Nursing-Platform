<?php

namespace App\Services;

use App\Contracts\ProfessorResearchServiceInterface;
use App\Models\ProfessorResearch;
use Illuminate\Support\Facades\DB;

class ProfessorResearchService implements ProfessorResearchServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): ProfessorResearch
    {
        return DB::transaction(function () use ($data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $research = ProfessorResearch::create($data);

            foreach ($attachments as $file) {
                $research->attachments()->create([
                    'path' => $this->files->store($file, 'professor_researches'),
                ]);
            }

            return $research;
        });
    }

    public function update(ProfessorResearch $research, array $data): bool
    {
        return DB::transaction(function () use ($research, $data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $research->update($data);

            foreach ($attachments as $file) {
                $research->attachments()->create([
                    'path' => $this->files->store($file, 'professor_researches'),
                ]);
            }

            return true;
        });
    }

    public function delete(ProfessorResearch $research): bool
    {
        return DB::transaction(function () use ($research) {
            foreach ($research->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $research->delete();
        });
    }
} 