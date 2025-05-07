<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'type',
        'publisher',
        'issn',
        'description'
    ];

    public function researches()
    {
        return $this->belongsToMany(Research::class, 'research_journal')
            ->withTimestamps();
    }

    /**
     * الحصول على قائمة أنواع المجلات
     */
    public static function getTypes(): array
    {
        return [
            'local' => 'محلية',
            'international' => 'عالمية',
        ];
    }
} 