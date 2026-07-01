<x-layouts.app title="Tai khoan dung chung">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex rounded-md border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                {{ auth()->user()->is_admin ? 'Admin access' : 'Read only' }}
            </div>
            <h1 class="text-3xl font-semibold tracking-tight">Tai khoan dung chung</h1>
            <p class="mt-2 text-sm text-zinc-600">{{ $accounts->count() }} tai khoan. Password va 2FA secret duoc ma hoa khi luu.</p>
        </div>

        <form method="GET" action="{{ route('accounts.index') }}" class="flex w-full rounded-md border border-zinc-200 bg-white p-1 shadow-sm sm:w-auto">
            <input
                name="q"
                value="{{ $query }}"
                placeholder="Tim website hoac email"
                class="min-w-0 flex-1 rounded-md border-0 bg-transparent px-3 py-2 text-sm outline-none sm:w-80"
            >
            <button class="rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800">
                Tim
            </button>
        </form>
    </div>

    <div class="overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm">
        <div class="hidden grid-cols-[1.1fr_1.35fr_1.45fr_1.1fr_auto] gap-4 border-b border-zinc-200 bg-zinc-50 px-5 py-3 text-xs font-semibold uppercase text-zinc-500 md:grid">
            <div>Website</div>
            <div>Email / Username</div>
            <div>Password</div>
            <div>OTP 2FA</div>
            <div></div>
        </div>

        @forelse ($accounts as $account)
            <div class="grid gap-4 border-b border-zinc-100 px-5 py-4 transition last:border-b-0 hover:bg-zinc-50/70 md:grid-cols-[1.1fr_1.35fr_1.45fr_1.1fr_auto] md:items-center">
                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Website</div>
                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        <a
                            href="{{ $account['website_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="break-all font-semibold text-zinc-950 underline decoration-zinc-300 underline-offset-4 hover:text-emerald-700 hover:decoration-emerald-500"
                        >
                            {{ $account['website_domain'] }}
                        </a>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Email / Username</div>
                    <div class="flex items-center gap-2">
                        <span class="break-all text-sm">{{ $account['login'] }}</span>
                        <button type="button" class="copy-btn rounded-md border border-zinc-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-zinc-700 hover:border-zinc-400 hover:bg-zinc-50" data-copy="{{ $account['login'] }}">
                            Copy
                        </button>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Password</div>
                    <div class="flex items-center gap-2" data-password-url="{{ $account['password_url'] }}">
                        <input value="***" readonly class="password-field min-w-0 flex-1 rounded-md border border-zinc-200 bg-zinc-50 px-3 py-2 font-mono text-sm text-zinc-700" data-hidden-value="***">
                        <button type="button" class="reveal-btn rounded-md border border-zinc-300 bg-white px-2.5 py-2 text-xs font-semibold text-zinc-700 hover:border-zinc-400 hover:bg-zinc-50">
                            Hien
                        </button>
                        <button type="button" class="copy-password-btn rounded-md border border-zinc-300 bg-white px-2.5 py-2 text-xs font-semibold text-zinc-700 hover:border-zinc-400 hover:bg-zinc-50">
                            Copy
                        </button>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">OTP 2FA</div>
                    <div class="flex items-center gap-2" data-otp-url="{{ $account['otp_url'] }}">
                        <span class="otp-code rounded-md bg-emerald-50 px-3 py-2 font-mono text-sm font-bold tracking-widest text-emerald-700 ring-1 ring-emerald-200">{{ $account['otp'] }}</span>
                        <span class="otp-countdown w-8 text-xs font-medium text-zinc-500">{{ $account['seconds_remaining'] }}s</span>
                        <button type="button" class="copy-otp-btn rounded-md border border-emerald-200 bg-white px-2.5 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                            Copy
                        </button>
                    </div>
                </div>

                <div class="flex gap-2 md:justify-end">
                    @if (auth()->user()->is_admin)
                        <a href="{{ $account['edit_url'] }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50">
                            Sua
                        </a>
                        <form method="POST" action="{{ $account['delete_url'] }}" onsubmit="return confirm('Xoa tai khoan nay?')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-md border border-red-200 bg-white px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">
                                Xoa
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-4 py-16 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-md bg-zinc-100 text-sm font-semibold text-zinc-500">
                    0
                </div>
                <div class="mt-3 text-sm font-semibold text-zinc-800">Chua co tai khoan nao</div>
                <p class="mt-1 text-sm text-zinc-500">Admin co the them tai khoan dung chung dau tien.</p>
            </div>
        @endforelse
    </div>
</x-layouts.app>
