<?php

namespace App\Services;

use App\Contracts\EventServiceInterface;
use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EventService implements EventServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    /** Create an event */
    public function create(array $data): Event
    {
        return DB::transaction(function () use ($data) {
            $attachments = Arr::pull($data, 'attachments', []);

            $event = Event::create($data);

            foreach ($attachments as $file) {
                $event->attachments()->create([
                    'path' => $this->files->store($file, 'events'),
                ]);
            }

            return $event;
        });
    }

    /** Update an event */
    public function update(Event $event, array $data): bool
    {
        return DB::transaction(function () use ($event, $data) {
            $newFiles = Arr::pull($data, 'attachments', []);
            $event->update($data);

            foreach ($newFiles as $file) {
                $event->attachments()->create([
                    'path' => $this->files->store($file, 'events'),
                ]);
            }

            return true;
        });
    }

    /** Delete an event (with its files) */
    public function delete(Event $event): bool
    {
        return DB::transaction(function () use ($event) {
            foreach ($event->attachments as $att) {
                $this->files->delete($att->path);
            }

            return $event->delete();
        });
    }
}
