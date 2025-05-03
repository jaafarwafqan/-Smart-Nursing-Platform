<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CampaignService
{
    public function __construct(private AttachmentService $files) {}

    public function create(array $data): Campaign
    {
        return DB::transaction(function () use ($data) {
            $attachments = Arr::pull($data, 'attachments', []);

            $campaign = Campaign::create($data);

            foreach ($attachments as $file) {
                $campaign->attachments()->create([
                    'path' => $this->files->store($file, 'campaigns'),
                ]);
            }
            return $campaign;
        });
    }

    public function update(Campaign $campaign, array $data): Campaign
    {
        return DB::transaction(function () use ($campaign, $data) {
            $newFiles = Arr::pull($data, 'attachments', []);
            $campaign->update($data);

            foreach ($newFiles as $file) {
                $campaign->attachments()->create([
                    'path' => $this->files->store($file, 'campaigns'),
                ]);
            }
            return $campaign;
        });
    }

    public function delete(Campaign $campaign): void
    {
        foreach ($campaign->attachments as $att) {
            $this->files->delete($att->path);
        }
        $campaign->delete();
    }
}
