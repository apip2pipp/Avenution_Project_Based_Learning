<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();
        $oldProfilePhotoPath = $user->profile_photo_path;

        if ($request->hasFile('profile_photo')) {
            $newProfilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');

            if (! $newProfilePhotoPath) {
                return Redirect::route('profile.edit')
                    ->withInput()
                    ->withErrors([
                        'profile_photo' => 'Profile photo upload failed. Please try again.',
                    ]);
            }

            $validated['profile_photo_path'] = $newProfilePhotoPath;
        }

        unset($validated['profile_photo']);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if (
            isset($validated['profile_photo_path'])
            && $oldProfilePhotoPath
            && $oldProfilePhotoPath !== $validated['profile_photo_path']
        ) {
            Storage::disk('public')->delete($oldProfilePhotoPath);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 🔥 HANYA validasi kalau user punya password
        if ($user->password) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current_password'],
            ]);
        }

        Auth::logout();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 🔵 GOOGLE USER (BELUM PUNYA PASSWORD)
        if (!$user->password) {

            $request->validate([
                'new_password' => ['required', 'min:6', 'confirmed'],
            ]);

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return back()->with('success', 'Password berhasil dibuat');
        }

        // 🟢 USER SUDAH PUNYA PASSWORD
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diupdate');
    }
}
