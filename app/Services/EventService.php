<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function __construct(private AttachmentService $files) {}

    /** إنشاء فعاليّة */
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

    /** تحديث فعاليّة */
    public function update(Event $event, array $data): Event
    {
        return DB::transaction(function () use ($event, $data) {
            $newFiles = Arr::pull($data, 'attachments', []);
            $event->update($data);

            foreach ($newFiles as $file) {
                $event->attachments()->create([
                    'path' => $this->files->store($file, 'events'),
                ]);
            }
            return $event;
        });
    }

    /** حذف فعاليّة (مع ملفاتها) */
    public function delete(Event $event): void
    {
        foreach ($event->attachments as $att) {
            $this->files->delete($att->path);
        }
        $event->delete();
    }
}
