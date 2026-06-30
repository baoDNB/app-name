<x-layouts.app title="Dang nhap">
    <div class="mx-auto max-w-sm rounded-md border border-zinc-200 bg-white p-6 shadow-sm">
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Dang nhap</h1>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-zinc-700">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 outline-none focus:border-zinc-950"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-zinc-700">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 outline-none focus:border-zinc-950"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm text-zinc-700">
                <input type="checkbox" name="remember" value="1" class="rounded border-zinc-300">
                Ghi nho dang nhap
            </label>

            <button class="w-full rounded-md bg-zinc-950 px-4 py-2 font-medium text-white hover:bg-zinc-800">
                Dang nhap
            </button>
        </form>
    </div>
</x-layouts.app>
