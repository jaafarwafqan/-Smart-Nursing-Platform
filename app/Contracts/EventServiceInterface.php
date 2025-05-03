<?php
//app/Contracts/EventServiceInterface.php
namespace App\Contracts;
use App\Models\Event;
interface EventServiceInterface
{
    public function create(array $data): Event;
    public function update(Event $event, array $data): bool;
    public function delete(Event $event): bool;
}
