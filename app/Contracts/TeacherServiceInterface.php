<?php

namespace App\Contracts;

use App\Models\Teacher;

interface TeacherServiceInterface
{
    public function create(array $data): Teacher;
    public function update(Teacher $teacher, array $data): bool;
    public function delete(Teacher $teacher): bool;
} 