<?php

namespace App\Contracts;

use App\Models\Journal;

interface JournalServiceInterface
{
    public function create(array $data): Journal;
    public function update(Journal $journal, array $data): bool;
    public function delete(Journal $journal): bool;
} 