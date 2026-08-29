<?php

namespace App\Services;

use App\Models\Advertisement;
use App\Models\AdvertisementSlot;
use Illuminate\Support\Collection;

class AdvertisementService
{
    public function getActiveAds(string $slotSlug, ?string $position = null): Collection
    {
        $slot = AdvertisementSlot::where('slug', $slotSlug)->first();

        if (!$slot) {
            return collect();
        }

        return $slot->advertisements()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
    }

    public function incrementImpression(Advertisement $ad): void
    {
        $ad->increment('impressions_count');
    }

    public function incrementClick(Advertisement $ad): void
    {
        $ad->increment('clicks_count');
    }

    public function isAdScheduled(Advertisement $ad): bool
    {
        return $ad->start_date->isPast() && $ad->end_date->isFuture();
    }

    public function getAdsForSlot(string $slotSlug): Collection
    {
        $slot = AdvertisementSlot::where('slug', $slotSlug)->first();

        if (!$slot) {
            return collect();
        }

        return $slot->advertisements()
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();
    }
}
