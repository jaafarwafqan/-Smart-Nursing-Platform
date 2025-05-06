<?php

namespace App\Contracts;

use App\Models\Student;

interface StudentServiceInterface
{
    public function create(array $data): Student;
    public function update(Student $student, array $data): bool;
    public function delete(Student $student): bool;
} 