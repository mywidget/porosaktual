<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementSlot;
use App\Services\AdvertisementService;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    protected AdvertisementService $advertisementService;

    public function __construct(AdvertisementService $advertisementService)
    {
        $this->advertisementService = $advertisementService;
    }

    public function index(Request $request)
    {
        $query = Advertisement::with('slot');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'expired') {
                $query->where('end_date', '<', now());
            } elseif ($request->status === 'scheduled') {
                $query->where('start_date', '>', now());
            }
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $limit = $request->input('limit', 20);
        $advertisements = $query->latest()->paginate($limit);

        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function create()
    {
        $slots = AdvertisementSlot::orderBy('name')->get();

        return view('admin.advertisements.create', compact('slots'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slot_id' => 'required|exists:advertisement_slots,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:adsense,banner,html_script,internal',
            'banner_image' => 'required_if:type,banner|nullable|image|max:2048',
            'html_code' => 'required_if:type,html_script|nullable|string',
            'url' => 'nullable|url|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $validated['is_active'] ?? true;

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('advertisements', 'public');
        }

        Advertisement::create($validated);

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement created successfully.');
    }

    public function edit(Advertisement $advertisement)
    {
        $slots = AdvertisementSlot::orderBy('name')->get();

        return view('admin.advertisements.edit', compact('advertisement', 'slots'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $rules = [
            'slot_id' => 'required|exists:advertisement_slots,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:adsense,banner,html_script,internal',
            'banner_image' => 'nullable|image|max:2048',
            'html_code' => 'nullable|string',
            'url' => 'nullable|url|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ];

        if ($request->type === 'banner' && !$advertisement->banner_image) {
            $rules['banner_image'] = 'required|image|max:2048';
        }

        if ($request->type === 'html_script' && !$advertisement->html_code) {
            $rules['html_code'] = 'required|string';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('advertisements', 'public');
        }

        $advertisement->update($validated);

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    public function destroy(Advertisement $advertisement)
    {
        $advertisement->delete();

        return redirect()->route('admin.advertisements.index')->with('success', 'Advertisement deleted successfully.');
    }

    public function toggleActive(Advertisement $advertisement)
    {
        $advertisement->update(['is_active' => !$advertisement->is_active]);

        return back()->with('success', 'Advertisement status updated.');
    }
}
