<?php

namespace App\Http\Controllers\Admin\Noticias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class UploadEditorImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Define the storage path
            $path = 'noticias/editor/' . date('Y/m');
            
            // Store the file in the public disk
            $file->storeAs($path, $filename, 'public');

            // Generate URL for the frontend
            $url = Storage::disk('public')->url($path . '/' . $filename);

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => $url
                ]
            ]);
        }

        return response()->json([
            'success' => 0,
            'message' => 'No image uploaded'
        ], 400);
    }
}
