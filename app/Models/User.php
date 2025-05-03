<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes;

    /** الحقول القابلة للتعبئة */
    protected $fillable = [
        'name',
        'email',
        'password',
        'branch_id',
        'type',        // admin | supervisor | user
        'is_admin',
    ];

    /** الحقول المخفية عند التحويل إلى JSON */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** التحويلات */
    protected $casts = [
        'is_admin'          => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /* العلاقات */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
