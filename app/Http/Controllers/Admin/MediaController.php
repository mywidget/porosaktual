<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('user');

        if ($request->filled('type')) {
            $query->where('file_type', 'like', $request->type . '%');
        }

        $media = $query->latest()->paginate(30);

        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('media', $fileName, 'public');

        $media = Media::create([
            'user_id' => auth()->id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'alt_text' => $request->alt_text,
            'title' => $request->title,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'media' => $media,
                'url' => asset('storage/' . $filePath),
            ]);
        }

        return back()->with('success', 'File uploaded successfully.');
    }

    public function destroy(Media $media)
    {
        $path = public_path('storage/' . $media->file_path);
        if (file_exists($path)) {
            unlink($path);
        }

        $media->delete();

        return back()->with('success', 'Media deleted successfully.');
    }
}
