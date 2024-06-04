<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
        Log::info("Accessing profile of user with ID: $id");
        $user = User::findOrFail($id);
        $videos = $user->videos;

        return view('profiles.show', compact('user', 'videos'));
    }

    public function edit()
    {
        $user = Auth::user();
        Log::info("Editing profile for user with ID: {$user->id}");
        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Resize the image to 150x150 and make it circular
            $resizedImage = Image::make($image)->fit(150, 150)->encode();

            // Ensure directory exists
            $directoryPath = storage_path('app/public/images/profile_pictures');
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }

            Storage::put('public/images/profile_pictures/' . $imageName, $resizedImage);

            $user->profile_picture = 'images/profile_pictures/' . $imageName;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->description = $request->description;

        try {
            $user->save();
        } catch (\Exception $e) {
            Log::error("Error updating profile: " . $e->getMessage());
            return back()->withErrors(['msg' => 'Error updating profile: ' . $e->getMessage()]);
        }

        return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name', 'LIKE', '%' . $search . '%')->get();
        return view('profiles.search', compact('users'));
    }
}


