<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form (User access)
     */
    public function edit(Request $request): View
    {
        $this->requireActiveUser();

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (User access)
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->requireActiveUser();
        $request->user()->fill($request->validated());

        if ($request->has('avatar')) {
            Storage::delete('public/' . User::find($request->user()->id)->avatar);
            $request->user()->update(['avatar' => $request->file('avatar')->store('avatars', 'public')]);
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with([
            'message'    => 'Profile updated successfully.',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Delete the user's account (User access)
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->requireActiveUser();
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with([
            'message'    => 'Your account has been deleted successfully.',
            'alert-type' => 'success',
        ]);
    }
}
