<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionController extends Controller
{
    public function subscribe($id)
    {
        $user = User::findOrFail($id);

        // Verificar si ya está suscrito
        if ($user->subscribers()->where('subscriber_id', Auth::id())->exists()) {
            return redirect()->back()->with('message', 'Ya estás suscrito a este usuario.');
        }

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->subscriber_id = Auth::id();
        $subscription->save();

        return redirect()->back()->with('message', 'Te has suscrito correctamente.');
    }

    public function unsubscribe($id)
    {
        $user = User::findOrFail($id);

        $subscription = $user->subscribers()->where('subscriber_id', Auth::id())->first();

        if ($subscription) {
            $subscription->delete();
            return redirect()->back()->with('message', 'Te has desuscrito correctamente.');
        }

        return redirect()->back()->with('message', 'No estabas suscrito a este usuario.');
    }
}
