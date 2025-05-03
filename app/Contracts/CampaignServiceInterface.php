<?php
// app/Contracts/CampaignServiceInterface.php
namespace App\Contracts;

use App\Models\Campaign;

interface CampaignServiceInterface
{
    public function create(array $data): Campaign;
    public function update(Campaign $campaign, array $data): bool;
    public function delete(Campaign $campaign): bool;
}
