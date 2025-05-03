<?php

namespace App\Services;

use App\Contracts\ResearchServiceInterface;
use App\Models\researches;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ResearchService implements ResearchServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    /** Create a research */
    public function create(array $data): researches
    {
        return DB::transaction(function () use ($data) {
            $attachments = Arr::pull($data, 'attachments', []);

            $research = researches::create($data);

            foreach ($attachments as $file) {
                $research->attachments()->create([
                    'path' => $this->files->store($file, 'researches'),
                ]);
            }

            return $research;
        });
    }

    /** Update a research */
    public function update(researches $research, array $data): bool
    {
        return DB::transaction(function () use ($research, $data) {
            $newFiles = Arr::pull($data, 'attachments', []);
            $research->update($data);

            foreach ($newFiles as $file) {
                $research->attachments()->create([
                    'path' => $this->files->store($file, 'researches'),
                ]);
            }

            return true;
        });
    }

    /** Delete a research (with its files) */
    public function delete(researches $research): bool
    {
        return DB::transaction(function () use ($research) {
            foreach ($research->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $research->delete();
        });
    }
}
