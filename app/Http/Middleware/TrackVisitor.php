<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\VisitorService;

class TrackVisitor
{
    protected $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$request->is('admin/*') && !$request->is('api/*') && !$request->is('livewire/*') && !$request->ajax()) {
            try {
                $this->visitorService->trackVisitor($request);
            } catch (\Exception $e) {
                // Silently fail
            }
        }

        return $response;
    }
}
