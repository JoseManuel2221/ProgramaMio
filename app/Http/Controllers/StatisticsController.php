<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Video;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Contar suscriptores
        $subscriberCount = $user->subscribers()->count();

        // Contar visualizaciones
        $viewsCount = Video::where('user_id', $user->id)->sum('views');

        // Contar likes y comentarios por video
        $videos = Video::where('user_id', $user->id)->withCount(['likes', 'comments'])->get();

        // Calcular ganancias
        $earnings = 0;
        foreach ($videos as $video) {
            $earnings += ($video->likes_count * .5) + ($video->comments_count * .2) + ($video->views * 1.5);
        }

        return view('statistics.index', compact('subscriberCount', 'viewsCount', 'videos', 'earnings'));
    }

    public function reset()
    {
        $user = Auth::user();

        // Restablecer las estadísticas
        $user->videos()->update(['views' => 0]);
        $user->videos()->with(['likes', 'comments'])->get()->each(function ($video) {
            $video->likes()->delete();
            $video->comments()->delete();
        });

        return redirect()->route('statistics.index')->with('success', 'Cobro exitosamente, enviado a su cuenta.');
    }
}

