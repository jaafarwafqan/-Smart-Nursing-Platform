<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    public function __construct(private AttachmentService $files) {}

    /** Create a user */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $attachments = Arr::pull($data, 'attachments', []);

            $user = User::create($data);

            foreach ($attachments as $file) {
                $user->attachments()->create([
                    'path' => $this->files->store($file, 'users'),
                ]);
            }

            return $user;
        });
    }

    /** Update a user */
    public function update(User $user, array $data): bool
    {
        return DB::transaction(function () use ($user, $data) {
            $newFiles = Arr::pull($data, 'attachments', []);
            $user->update($data);

            foreach ($newFiles as $file) {
                $user->attachments()->create([
                    'path' => $this->files->store($file, 'users'),
                ]);
            }

            return true;
        });
    }

    /** Delete a user (with its files) */
    public function delete(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            foreach (($user->attachments ?? []) as $att) {
                $this->files->delete($att->path);
            }

            return $user->delete();
        });
    }
}
