<?php

namespace App\Services;

use App\Contracts\CampaignServiceInterface;
use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;

class CampaignService implements CampaignServiceInterface
{
    public function create(array $data): Campaign
    {
        $files = $data['attachments'] ?? [];
        unset($data['attachments']);

        $campaign = Campaign::create($data);

        if ($files) {
            $paths = collect($files)
                ->map(fn($f) => $f->store('campaigns', 'public'))
                ->toArray();
            $campaign->update(['attachments' => $paths]);
        }

        return $campaign;
    }

    public function update(Campaign $campaign, array $data): bool
    {
        // مثال مختصر
        return $campaign->update($data);
    }

    public function delete(Campaign $campaign): bool
    {
        collect($campaign->attachments ?? [])
            ->each(fn($p) => Storage::disk('public')->delete($p));

        return $campaign->delete();
    }
}
