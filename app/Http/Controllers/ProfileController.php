<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;


class ProfileController extends Controller
{
    //
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }
    
    //
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar'))
        {
            if ($user->avatar)
            {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $user->update($validated);
        return back()->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request )
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password))
        {
            return back()
                        ->withErrors(['current_password' => 'Current password is incorrect'])
                        ->with('error', 'Password update failed');
        }
        
        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully');
    }
}
