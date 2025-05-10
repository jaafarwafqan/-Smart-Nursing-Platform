<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Research extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'researches';

    // حالات البحث
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

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
        'research_title',
        'research_type',
        'start_date',
        'end_date',
        'status',
        'publication_status',
        'completion_percentage',
        'description',
        'title',
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

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_researches')
            ->withPivot(['role', 'study_type', 'status'])
            ->withTimestamps();
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'research_journal')
            ->withTimestamps();
    }

    /**
     * الحصول على قائمة حالات البحث
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'قيد الانتظار',
            self::STATUS_IN_PROGRESS => 'قيد التنفيذ',
            self::STATUS_COMPLETED => 'مكتمل',
            self::STATUS_CANCELLED => 'ملغي',
        ];
    }

    /**
     * الحصول على قائمة أنواع البحث
     */
    public static function getResearchTypes(): array
    {
        return [
            self::TYPE_QUALITATIVE => 'نوعي',
            self::TYPE_QUANTITATIVE => 'كمي',
        ];
    }

    /**
     * الحصول على قائمة حالات النشر
     */
    public static function getPublicationStatuses(): array
    {
        return [
            self::PUBLICATION_DRAFT => 'مسودة',
            self::PUBLICATION_SUBMITTED => 'تم التقديم',
            self::PUBLICATION_UNDER_REVIEW => 'قيد المراجعة',
            self::PUBLICATION_ACCEPTED => 'تم القبول',
            self::PUBLICATION_PUBLISHED => 'تم النشر',
        ];
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
    public function scopeByStatus($query, $status)
    {
        return $query->when($status, fn($q) => $q->where('status', $status));
    }
    public function scopeSearchByTitle($query, $title)
    {
        return $query->when($title, fn($q) => $q->where('title', 'like', "%$title%"));
    }
}
