<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\JsonResponse;

class AdvertisementController extends Controller
{
    public function index($slot)
    {
        $ads = Advertisement::active()
            ->where('slot', $slot)
            ->get();

        return response()->json($ads);
    }
}
