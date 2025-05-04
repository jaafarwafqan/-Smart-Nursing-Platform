<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Research extends Model
{
    use SoftDeletes;

    protected $table = 'researches';

    // حالات البحث
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'branch_id',
        'research_title',
        'research_type',   // أطروحة، بحث تطبيقي،…
        'start_date',
        'end_date',
        'status',          // جاري - مكتمل - موقوف
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
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
}
