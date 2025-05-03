<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService
{
    public function store(UploadedFile $file, string $folder = 'attachments'): string
    {
        $name = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        return $file->storeAs($folder, $name, 'public');   // public disk
    }

    public function delete(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
