<?php

namespace App\Contracts;

use App\Models\Professor;

interface ProfessorServiceInterface
{
    public function create(array $data): Professor;
    public function update(Professor $professor, array $data): bool;
    public function delete(Professor $professor): bool;
} 