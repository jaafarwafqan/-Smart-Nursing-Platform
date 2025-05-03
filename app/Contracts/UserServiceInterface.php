<?php
//app/Contracts/UserServiceInterface.php
namespace App\Contracts;
use App\Models\User;
interface UserServiceInterface
{
    public function create(array $data): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
}
