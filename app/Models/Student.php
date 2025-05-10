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
        return $this->belongsToMany(Research::class, 'student_researches')
            ->withPivot(['role', 'study_type', 'status'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeByStudyType($query, $type)
    {
        return $query->when($type, fn($q) => $q->where('study_type', $type));
    }
    public function scopeByGender($query, $gender)
    {
        return $query->when($gender, fn($q) => $q->where('gender', $gender));
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->when($name, fn($q) => $q->where('name', 'like', "%$name%"));
    }
} 