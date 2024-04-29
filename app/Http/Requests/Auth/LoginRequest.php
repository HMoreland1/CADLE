<?php

namespace App\Http\Requests\Auth;

use App\Models\AuthLog;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');

        // Retrieve the user from the database using the provided email address
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            RateLimiter::hit($this->throttleKey());
            AuthLog::create([
                'user_id' => "NO ID",
                'ip_address' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'type' => 'login_failed',
            ]);
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);

        }

        // Append the user's salt to the password
        $credentials['password'] = env('PEPPER') . $user->salt . $credentials['password'];

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            AuthLog::create([
                'user_id' => Auth::id(),
                'ip_address' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'type' => 'login_failed',
            ]);
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);

        } else {
            AuthLog::create([
                'user_id' => Auth::id(),
                'ip_address' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'logout_at' => now(),
                'type' => 'login_success',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }


    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());
        AuthLog::create([
            'user_id' => Auth::id(),
            'ip_address' => $this->ip(),
            'user_agent' => $this->userAgent(),
            'type' => 'login_failed',
        ]);
        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
