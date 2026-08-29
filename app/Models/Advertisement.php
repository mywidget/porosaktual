<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advertisement extends Model
{
    use HasFactory;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }

    protected $fillable = [
        'slot_id',
        'title',
        'type',
        'banner_image',
        'html_code',
        'url',
        'start_date',
        'end_date',
        'impressions_count',
        'clicks_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(AdvertisementSlot::class, 'slot_id');
    }
}
