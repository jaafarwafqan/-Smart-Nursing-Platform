<?php
//app/Contracts/ResearchServiceInterface.php
namespace App\Contracts;
use App\Models\researches;
interface ResearchServiceInterface
{
    public function create(array $data): researches;
    public function update(researches $research, array $data): bool;
    public function delete(researches $research): bool;
}
