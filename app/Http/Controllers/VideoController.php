<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::where('user_id', Auth::id())->get();
        return view('videos.index', compact('videos'));
    }

    public function create()
    {
        return view('videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video' => 'required|mimes:mp4,mov,avi,flv,wmv,avi,webm|max:2048000' // Aumenta el tamaño máximo a 2GB
        ]);
 
        // Almacenar el video en la carpeta 'videos' dentro de 'storage/app/public'
        $videoPath = $request->file('video')->store('videos', 'public');
 
        Video::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => $videoPath
        ]);
 
        return redirect()->route('videos.index');
    }
   
    public function show(Video $video)
{
    // Incrementar el contador de vistas
    $video->increment('views');

    $otherVideos = Video::where('user_id', $video->user_id)
                        ->where('id', '!=', $video->id)
                        ->limit(5)
                        ->get();

    return view('videos.show', compact('video', 'otherVideos'));
}

    public function edit(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('video')) {
            // Almacenar el video en la carpeta 'videos' dentro de 'storage/app/public'
            $videoPath = $request->file('video')->store('videos', 'public');
            $video->video_path = $videoPath;
        }

        $video->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('videos.index');
    }

    public function destroy(Video $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $video->delete();
        return redirect()->route('videos.index');
    }
}

