<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'gender', 'academic_rank', 'college', 'department',
        'research_interests', 'phone', 'email', 'notes'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function researches()
    {
        return $this->belongsToMany(Research::class, 'professor_research')
            ->withPivot(['role'])
            ->withTimestamps();
    }

    public function professorResearches()
    {
        return $this->belongsToMany(\App\Models\ProfessorResearch::class, 'professor_research_professor')
            ->withPivot('role')
            ->withTimestamps();
    }
} 