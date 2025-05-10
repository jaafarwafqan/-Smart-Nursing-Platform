<?php

namespace App\Services;

use App\Contracts\JournalServiceInterface;
use App\Models\Journal;
use Illuminate\Support\Facades\DB;

class JournalService implements JournalServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): Journal
    {
        return DB::transaction(function () use ($data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $journal = Journal::create($data);

            foreach ($attachments as $file) {
                $journal->attachments()->create([
                    'path' => $this->files->store($file, 'journals'),
                ]);
            }

            return $journal;
        });
    }

    public function update(Journal $journal, array $data): bool
    {
        return DB::transaction(function () use ($journal, $data) {
            $attachments = $data['attachments'] ?? [];
            unset($data['attachments']);

            $journal->update($data);

            foreach ($attachments as $file) {
                $journal->attachments()->create([
                    'path' => $this->files->store($file, 'journals'),
                ]);
            }

            return true;
        });
    }

    public function delete(Journal $journal): bool
    {
        return DB::transaction(function () use ($journal) {
            foreach ($journal->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $journal->delete();
        });
    }
} 