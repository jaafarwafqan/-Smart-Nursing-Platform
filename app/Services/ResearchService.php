<?php

namespace App\Services;

use App\Models\researches;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ResearchService
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): researches    {
        return DB::transaction(function () use ($data) {
            $attachments = Arr::pull($data, 'attachments', []);

            $researches = researches::create($data);

            foreach ($attachments as $file) {
                $researches->attachments()->create([
                    'path' => $this->files->store($file, 'researches'),
                ]);
            }
            return $researches;
        });
    }

    public function update(researches $researches, array $data): researches    {
        return DB::transaction(function () use ($researches, $data) {
            $newFiles = Arr::pull($data, 'attachments', []);
            $researches->update($data);

            foreach ($newFiles as $file) {
                $researches->attachments()->create([
                    'path' => $this->files->store($file, 'researches'),
                ]);
            }
            return $researches;
        });
    }

    public function delete(researches $researches): void
    {
        foreach ($researches->attachments as $att) {
            $this->files->delete($att->path);
        }
        $researches->delete();
    }
}
