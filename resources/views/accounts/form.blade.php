<x-layouts.app title="{{ $mode === 'create' ? 'Them tai khoan' : 'Sua tai khoan' }}">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">{{ $mode === 'create' ? 'Them tai khoan' : 'Sua tai khoan' }}</h1>
        </div>
        <a href="{{ route('accounts.index') }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm font-medium hover:bg-zinc-50">
            Quay lai
        </a>
    </div>

    <form
        method="POST"
        action="{{ $mode === 'create' ? route('accounts.store') : route('accounts.update', $account) }}"
        class="max-w-2xl rounded-md border border-zinc-200 bg-white p-6 shadow-sm"
    >
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <div class="space-y-5">
            <div>
                <label for="website_domain" class="mb-1 block text-sm font-medium text-zinc-700">Website domain</label>
                <input
                    id="website_domain"
                    name="website_domain"
                    value="{{ old('website_domain', $account->website_domain) }}"
                    required
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 outline-none focus:border-zinc-950"
                >
                @error('website_domain')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="login" class="mb-1 block text-sm font-medium text-zinc-700">Username hoac email</label>
                <input
                    id="login"
                    name="login"
                    value="{{ old('login', $account->login) }}"
                    required
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 outline-none focus:border-zinc-950"
                >
                @error('login')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-zinc-700">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    @if ($mode === 'create') required @endif
                    autocomplete="new-password"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 outline-none focus:border-zinc-950"
                >
                @if ($mode === 'edit')
                    <p class="mt-1 text-xs text-zinc-500">De trong neu khong doi password.</p>
                @endif
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="two_factor_secret" class="mb-1 block text-sm font-medium text-zinc-700">2FA secret</label>
                <input
                    id="two_factor_secret"
                    name="two_factor_secret"
                    type="password"
                    @if ($mode === 'create') required @endif
                    autocomplete="off"
                    class="w-full rounded-md border border-zinc-300 px-3 py-2 outline-none focus:border-zinc-950"
                >
                @if ($mode === 'edit')
                    <p class="mt-1 text-xs text-zinc-500">Secret goc khong hien lai sau khi luu. Nhap secret moi neu can thay.</p>
                @endif
                @error('two_factor_secret')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('accounts.index') }}" class="rounded-md border border-zinc-300 px-4 py-2 text-sm font-medium hover:bg-zinc-50">
                Huy
            </a>
            <button class="rounded-md bg-zinc-950 px-4 py-2 text-sm font-medium text-white hover:bg-zinc-800">
                Luu
            </button>
        </div>
    </form>
</x-layouts.app>
