<?php

namespace App\Contracts;

use App\Models\ProfessorResearch;

interface ProfessorResearchServiceInterface
{
    public function create(array $data): ProfessorResearch;
    public function update(ProfessorResearch $research, array $data): bool;
    public function delete(ProfessorResearch $research): bool;
} 