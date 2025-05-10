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
        return $this->belongsToMany(\App\Models\ProfessorResearch::class, 'professor_research', 'professor_id', 'research_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    // Scopes
    public function scopeByAcademicRank($query, $rank)
    {
        return $query->when($rank, fn($q) => $q->where('academic_rank', $rank));
    }
    public function scopeByGender($query, $gender)
    {
        return $query->when($gender, fn($q) => $q->where('gender', $gender));
    }
    public function scopeByCollege($query, $college)
    {
        return $query->when($college, fn($q) => $q->where('college', $college));
    }
    public function scopeByDepartment($query, $department)
    {
        return $query->when($department, fn($q) => $q->where('department', $department));
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->when($name, fn($q) => $q->where('name', 'like', "%$name%"));
    }
} 