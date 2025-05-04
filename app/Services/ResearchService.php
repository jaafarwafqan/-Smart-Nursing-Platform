<?php

namespace App\Services;

use App\Contracts\ResearchServiceInterface;
use App\Models\Research;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResearchService implements ResearchServiceInterface
{
    public function __construct(private Storage $files) {}

    /** Create a research */
    public function create(array $data): Research
    {
        return DB::transaction(function () use ($data) {
            $attachments = Arr::pull($data, 'attachments', []);

            $research = Research::create($data);

            foreach ($attachments as $file) {
                $research->attachments()->create([
                    'path' => $this->files->store($file, 'researches'),
                ]);
            }

            return $research;
        });
    }

    /** Update a research */
    public function update(Research $research, array $data): bool
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
    public function delete(Research $research): bool
    {
        return DB::transaction(function () use ($research) {
            foreach ($research->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $research->delete();
        });
    }
}
