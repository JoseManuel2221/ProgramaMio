<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($id)
    {
        $video = Video::findOrFail($id);

        if (!$video->likes()->where('user_id', Auth::id())->exists()) {
            $like = new Like();
            $like->user_id = Auth::id();
            $like->video_id = $video->id;
            $like->save();
        }

        return redirect()->back();
    }

    public function unlike($id)
    {
        $video = Video::findOrFail($id);

        $like = $video->likes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        }

        return redirect()->back();
    }
}

