<?php

namespace App\Services;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VisitorService
{
    public function trackVisitor(Request $request): Visitor
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $today = now()->toDateString();

        $isUnique = !Visitor::where('ip_address', $ip)
            ->whereDate('created_at', $today)
            ->exists();

        return Visitor::create([
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'url' => $request->url(),
            'referer' => $request->header('referer'),
            'device' => $this->detectDevice($userAgent),
            'browser' => $this->detectBrowser($userAgent),
            'is_unique' => $isUnique,
        ]);
    }

    public function getStats(string $period = 'day', int $days = 30): array
    {
        $startDate = Carbon::now()->subDays($days);

        $query = DB::table('visitors')
            ->where('created_at', '>=', $startDate);

        if ($period === 'day') {
            $results = $query
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN is_unique = 1 THEN 1 ELSE 0 END) as unique_count')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return $results->pluck('total', 'date')->toArray();
        }

        $results = $query
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN is_unique = 1 THEN 1 ELSE 0 END) as unique_count')
            )
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return $results->pluck('total', 'hour')->toArray();
    }

    public function getUniqueVisitors(int $days = 30): int
    {
        $startDate = Carbon::now()->subDays($days);

        return (int) Visitor::where('created_at', '>=', $startDate)
            ->where('is_unique', true)
            ->count();
    }

    public function getTotalViews(int $days = 30): int
    {
        $startDate = Carbon::now()->subDays($days);

        return (int) Visitor::where('created_at', '>=', $startDate)
            ->count();
    }

    protected function detectDevice(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'unknown';
        }

        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            return 'mobile';
        }

        if (preg_match('/Tablet|iPad/i', $userAgent)) {
            return 'tablet';
        }

        return 'desktop';
    }

    protected function detectBrowser(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'unknown';
        }

        if (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        }

        if (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        }

        if (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        }

        if (preg_match('/Edge/i', $userAgent)) {
            return 'Edge';
        }

        if (preg_match('/Opera|OPR/i', $userAgent)) {
            return 'Opera';
        }

        return 'other';
    }
}
