<x-guest-layout title="Reset Admin Password">
    <main class="min-h-screen bg-zinc-950 px-5 py-10 text-zinc-100">
        <div class="mx-auto flex min-h-[80vh] max-w-md items-center">
            <form method="POST" action="{{ route('admin.password.update') }}" class="w-full rounded-lg border border-white/10 bg-white/[0.04] p-6 shadow-2xl">
                @csrf
                <h1 class="text-3xl font-semibold">Reset Password</h1>
                <p class="mt-2 text-sm text-zinc-400">Choose a new admin password of at least 8 characters.</p>

                @if ($errors->any())
                    <div class="mt-5 rounded-md border border-red-400/30 bg-red-500/10 p-3 text-sm text-red-200">{{ $errors->first() }}</div>
                @endif

                <input type="hidden" name="token" value="{{ $token }}">
                <label class="mt-6 block text-sm font-medium text-zinc-300" for="email">Admin Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required readonly class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 text-zinc-300">

                <label class="mt-4 block text-sm font-medium text-zinc-300" for="password">New Password</label>
                <input id="password" name="password" type="password" required autofocus autocomplete="new-password" class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none ring-teal-400/50 focus:ring-2">

                <label class="mt-4 block text-sm font-medium text-zinc-300" for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none ring-teal-400/50 focus:ring-2">

                <button class="mt-6 w-full rounded-md bg-teal-400 px-4 py-3 font-semibold text-zinc-950 hover:bg-teal-300">Reset Password</button>
            </form>
        </div>
    </main>
</x-guest-layout>
