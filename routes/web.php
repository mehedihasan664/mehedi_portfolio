<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\PortfolioHome;
use App\Models\AdminCredential;
use App\Models\PortfolioProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', PortfolioHome::class)->name('home');

Route::get('/admin/login', fn () => view('admin.login'))->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! AdminCredential::credentialsMatch((string) $request->email, (string) $request->password)) {
        return back()->withErrors(['email' => 'The provided admin credentials are incorrect.'])->onlyInput('email');
    }

    $request->session()->regenerate();
    $request->session()->put('portfolio_admin', true);

    return redirect()->route('admin.dashboard');
})->middleware('throttle:5,1')->name('admin.login.attempt');

Route::get('/admin/forgot-password', fn () => view('admin.forgot-password'))
    ->name('admin.password.request');

Route::post('/admin/forgot-password', function (Request $request) {
    $validated = $request->validate(['email' => ['required', 'email']]);
    $email = mb_strtolower($validated['email']);

    if (hash_equals(mb_strtolower(AdminCredential::email()), $email)) {
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($token), 'created_at' => now()],
        );

        Mail::send('emails.admin-password-reset', [
            'resetUrl' => route('admin.password.reset', ['token' => $token, 'email' => $email]),
        ], function ($message) use ($email): void {
            $message->to($email)->subject('Reset your portfolio admin password');
        });
    }

    return back()->with('status', 'If that email matches the admin account, a password reset link has been sent.');
})->middleware('throttle:3,1')->name('admin.password.email');

Route::get('/admin/reset-password/{token}', fn (string $token, Request $request) => view('admin.reset-password', [
    'token' => $token,
    'email' => $request->query('email'),
]))->name('admin.password.reset');

Route::post('/admin/reset-password', function (Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email'],
        'token' => ['required', 'string'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $email = mb_strtolower($validated['email']);
    $reset = DB::table('password_reset_tokens')->where('email', $email)->first();
    $validToken = $reset
        && $reset->created_at
        && Carbon::parse($reset->created_at)->isAfter(now()->subMinutes(60))
        && Hash::check($validated['token'], $reset->token)
        && hash_equals(mb_strtolower(AdminCredential::email()), $email);

    if (! $validToken) {
        return back()->withErrors(['email' => 'This password reset link is invalid or has expired.'])->onlyInput('email');
    }

    AdminCredential::changePassword($validated['password']);
    DB::table('password_reset_tokens')->where('email', $email)->delete();

    return redirect()->route('admin.login')->with('status', 'Password reset successfully. You can now log in.');
})->middleware('throttle:5,1')->name('admin.password.update');

Route::middleware('portfolio.admin')->group(function (): void {
    Route::get('/admin', Dashboard::class)->name('admin.dashboard');

    Route::post('/admin/profile-photo', function (Request $request) {
        $validated = $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'profile_photo.required' => 'Please select a profile photo first.',
            'profile_photo.max' => 'The processed profile photo must be under 2MB.',
        ]);

        $profile = PortfolioProfile::query()->firstOrCreate([], [
            'name' => 'Mehedi Hasan',
            'title' => 'Laravel Developer',
            'tagline' => 'I build fast, clean, and maintainable web applications.',
        ]);

        $file = $validated['profile_photo'];
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $extension = $extension === 'jpeg' ? 'jpg' : $extension;
        $path = $file->storeAs('profile', 'profile-'.Str::uuid().'.'.$extension, 'public');

        if (! $path) {
            return back()->withErrors(['profile_photo' => 'The profile photo could not be saved. Please try again.']);
        }

        $oldPath = $profile->profile_photo_path;
        $profile->update(['profile_photo_path' => $path]);

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route('admin.dashboard')->with('admin_status', 'Profile photo uploaded.');
    })->name('admin.profile-photo.upload');
});
