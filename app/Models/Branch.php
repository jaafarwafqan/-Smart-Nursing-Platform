<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    // إذا استخدمت guarded بدلاً من fillable
    protected $guarded = [];
    // أو لو أردت fillable:
    // protected $fillable = ['name'];
    public function badgeColor(): string
    {
        return match($this->id) {
            1 => 'primary',
            2 => 'success',
            3 => 'warning',
            default => 'info',
        };
    }

}
