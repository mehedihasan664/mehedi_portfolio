<x-guest-layout title="Forgot Admin Password">
    <main class="min-h-screen bg-zinc-950 px-5 py-10 text-zinc-100">
        <div class="mx-auto flex min-h-[80vh] max-w-md items-center">
            <form method="POST" action="{{ route('admin.password.email') }}" class="w-full rounded-lg border border-white/10 bg-white/[0.04] p-6 shadow-2xl">
                @csrf
                <a href="{{ route('admin.login') }}" class="text-sm text-teal-300">Back to login</a>
                <h1 class="mt-5 text-3xl font-semibold">Forgot Password</h1>
                <p class="mt-2 text-sm text-zinc-400">Enter your admin email to receive a reset link.</p>

                @if (session('status'))
                    <div class="mt-5 rounded-md border border-teal-400/30 bg-teal-500/10 p-3 text-sm text-teal-200">{{ session('status') }}</div>
                @endif
                @error('email') <div class="mt-5 text-sm text-red-300">{{ $message }}</div> @enderror

                <label class="mt-6 block text-sm font-medium text-zinc-300" for="email">Admin Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 outline-none ring-teal-400/50 focus:ring-2">

                <button class="mt-6 w-full rounded-md bg-teal-400 px-4 py-3 font-semibold text-zinc-950 hover:bg-teal-300">Send Reset Link</button>
            </form>
        </div>
    </main>
</x-guest-layout>
