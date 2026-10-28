<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['files' => 'required|array|max:10', 'files.*' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120']);
        $files = [];
        foreach ($request->file('files', []) as $image) {
            $path = $image->store('editor/images', 'public');
            $files[] = ['file' => basename($path), 'url' => asset('storage/'.$path)];
        }
        return response()->json(['success' => true, 'files' => $files]);
    }
}
