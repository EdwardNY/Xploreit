<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();

        if ($user->isLecturer()) {
            $courses = $user->createdCourses()->latest()->get();
            return view('profile.show', compact('user', 'courses'));
        }

        $enrollments = $user->enrollments()->with('course')->latest()->get();
        return view('profile.show', compact('user', 'enrollments'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024', // More specific validation
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $this->handleProfilePictureUpload($request, $user);
        }

        // Update user data
        $user->update([
            'name' => $validated['name'],
            'bio' => $validated['bio'] ?? $user->bio,
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The provided password does not match our records.'
            ]);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password changed successfully!');
    }

    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
            $user->update(['profile_picture' => null]);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile picture deleted successfully!');
    }

    /**
     * Handle profile picture upload and cleanup
     */
    private function handleProfilePictureUpload(Request $request, $user)
    {
        try {
            // Delete old profile picture if it exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture with unique name
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile-pictures', $filename, 'public');

            $user->profile_picture = $path;
        } catch (\Exception $e) {
            // Log the error and continue without updating picture
            \Log::error('Profile picture upload failed: ' . $e->getMessage());
            throw new \Exception('Failed to upload profile picture. Please try again.');
        }
    }
}
