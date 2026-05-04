<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    { 
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Belum login');
        }

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Belum login');
        }

        return view('profile.edit', compact('user'));
    }

    // 📸 tampilkan foto
    public function photo()
    {
        $user = auth()->user();

        if (!$user || !$user->photo || !Storage::disk('public')->exists($user->photo)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($user->photo));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Belum login');
        }

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 📸 upload foto
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'users/profiles/' . $filename;

            Storage::disk('public')->putFileAs('users/profiles', $file, $filename);
            $validated['photo'] = $path;
        }

        $user->update($validated);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}