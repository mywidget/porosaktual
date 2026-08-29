<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function destroy(Request $request, $id)
    {
        $media = Media::find($id);

        if (!$media) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Media tidak ditemukan.'], 404);
            }
            return back()->with('error', 'Media tidak ditemukan.');
        }

        $filePath = $media->file_path;
        $deleted = $media->delete();

        if ($deleted && $filePath) {
            $path = public_path('storage/' . $filePath);
            if (file_exists($path) && is_file($path)) {
                @unlink($path);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => $deleted,
                'message' => $deleted ? 'Media berhasil dihapus.' : 'Gagal menghapus media.',
                'remaining' => Media::count(),
            ]);
        }

        return back()->with('success', 'Media berhasil dihapus.');
    }
}
