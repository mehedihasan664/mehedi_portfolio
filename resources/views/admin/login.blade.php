<x-guest-layout title="Admin Login">
    <main class="min-h-screen bg-zinc-950 px-5 py-10 text-zinc-100">
        <div class="mx-auto flex min-h-[80vh] max-w-md items-center">
            <form method="POST" action="{{ route('admin.login.attempt') }}" class="w-full rounded-lg border border-white/10 bg-white/[0.04] p-6 shadow-2xl">
                @csrf
                <a href="{{ route('home') }}" class="text-sm text-teal-300">Back to portfolio</a>
                <h1 class="mt-5 text-3xl font-semibold">Admin Login</h1>
                <p class="mt-2 text-sm text-zinc-400">Use your admin email and password to manage content.</p>

                @if (session('status'))
                    <div class="mt-5 rounded-md border border-teal-400/30 bg-teal-500/10 p-3 text-sm text-teal-200">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="mt-5 rounded-md border border-red-400/30 bg-red-500/10 p-3 text-sm text-red-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <label class="mt-6 block text-sm font-medium text-zinc-300" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 text-zinc-100 outline-none ring-teal-400/50 focus:ring-2">

                <label class="mt-4 block text-sm font-medium text-zinc-300" for="password">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-2 w-full rounded-md border border-white/10 bg-zinc-900 px-4 py-3 text-zinc-100 outline-none ring-teal-400/50 focus:ring-2">

                <div class="mt-3 text-right">
                    <a href="{{ route('admin.password.request') }}" class="text-sm text-teal-300 hover:text-teal-200">Forgot password?</a>
                </div>

                <button class="mt-6 w-full rounded-md bg-teal-400 px-4 py-3 font-semibold text-zinc-950 transition hover:bg-teal-300">
                    Login
                </button>
            </form>
        </div>
    </main>
</x-guest-layout>
