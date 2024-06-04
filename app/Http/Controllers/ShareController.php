<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Share;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function share($id)
    {
        $video = Video::findOrFail($id);

        if (!$video->shares()->where('user_id', Auth::id())->exists()) {
            $share = new Share();
            $share->user_id = Auth::id();
            $share->video_id = $video->id;
            $share->save();
        }

        return redirect()->back();
    }
}
