<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'channel_name' => 'nullable|string|max:255',
            'channel_description' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('storage/images/profile_pictures'), $imageName);
            $user->profile_picture = 'images/profile_pictures/' . $imageName;
        }

        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('description')) {
            $user->description = $request->description;
        }
        if ($request->filled('channel_name')) {
            $user->channel_name = $request->channel_name;
        }
        if ($request->filled('channel_description')) {
            $user->channel_description = $request->channel_description;
        }

        $user->save();

        return redirect()->route('settings.edit')->with('success', 'Configuraciones actualizadas correctamente.');
    }
}






