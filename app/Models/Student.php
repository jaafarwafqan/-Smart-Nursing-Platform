<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'university_id',
        'email',
        'phone',
        'gender',
        'study_type',
        'branch_id',
        'notes'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function researches()
    {
        return $this->belongsToMany(Research::class)
            ->withPivot('role')
            ->withTimestamps();
    }
} 