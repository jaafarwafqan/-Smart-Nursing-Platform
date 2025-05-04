<?php
//app/Contracts/ResearchServiceInterface.php
namespace App\Contracts;
use App\Models\Research;
interface ResearchServiceInterface
{
    public function create(array $data): Research;
    public function update(Research $research, array $data): bool;
    public function delete(Research $research): bool;
}
