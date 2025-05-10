<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfessorResearch extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'professor_researches';

    // أنواع البحث
    const TYPE_QUALITATIVE = 'qualitative';
    const TYPE_QUANTITATIVE = 'quantitative';

    // حالات النشر
    const PUBLICATION_DRAFT = 'draft';
    const PUBLICATION_SUBMITTED = 'submitted';
    const PUBLICATION_UNDER_REVIEW = 'under_review';
    const PUBLICATION_ACCEPTED = 'accepted';
    const PUBLICATION_PUBLISHED = 'published';

    protected $fillable = [
        'branch_id',
        'title',
        'research_type',
        'start_date',
        'end_date',
        'publication_status',
        'completion_percentage',
        'abstract',
        'keywords',
        'file_path',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'completion_percentage' => 'integer',
    ];

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_research_professor')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'professor_research_journal')
            ->withTimestamps();
    }

    public function getPublicationStatusTextAttribute()
    {
        return [
            self::PUBLICATION_DRAFT => 'مسودة',
            self::PUBLICATION_SUBMITTED => 'تم التقديم',
            self::PUBLICATION_UNDER_REVIEW => 'قيد المراجعة',
            self::PUBLICATION_ACCEPTED => 'تم القبول',
            self::PUBLICATION_PUBLISHED => 'تم النشر',
        ][$this->publication_status] ?? $this->publication_status;
    }

    public function getResearchTypeTextAttribute()
    {
        return [
            self::TYPE_QUALITATIVE => 'نوعي',
            self::TYPE_QUANTITATIVE => 'كمي',
        ][$this->research_type] ?? $this->research_type;
    }

    // Scopes
    public function scopeByPublicationStatus($query, $status)
    {
        return $query->when($status, fn($q) => $q->where('publication_status', $status));
    }
    public function scopeByResearchType($query, $type)
    {
        return $query->when($type, fn($q) => $q->where('research_type', $type));
    }
    public function scopeSearchByTitle($query, $title)
    {
        return $query->when($title, fn($q) => $q->where('title', 'like', "%$title%"));
    }
} 