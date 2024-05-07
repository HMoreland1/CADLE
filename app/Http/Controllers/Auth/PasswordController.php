<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {

        $user = $request->user();

        $request->merge(['current_password' => $request->current_password . env('PEPPER') . $user->salt ]);
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);



        // Generate new salt
        $salt = Str::random(16);

        // Combine the new password with the salt and hash it
        $hashedPassword = Hash::make($request->password . env('PEPPER') . $salt);

        // Update the user's password
        $user->update([
            'password' => $hashedPassword,
            'salt' => $salt,
        ]);

        AuthLog::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'type' => 'password_change',
        ]);

        return back();
    }

}
