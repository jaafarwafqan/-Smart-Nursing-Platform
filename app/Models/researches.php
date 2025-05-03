<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class researches extends Model
{
    use SoftDeletes;

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
        'end_date'   => 'date',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
