<x-layouts.app title="Tai khoan dung chung">
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Tai khoan dung chung</h1>
            <p class="mt-1 text-sm text-zinc-600">{{ $accounts->count() }} tai khoan</p>
        </div>

        <form method="GET" action="{{ route('accounts.index') }}" class="flex w-full gap-2 sm:w-auto">
            <input
                name="q"
                value="{{ $query }}"
                placeholder="Tim website hoac email"
                class="min-w-0 flex-1 rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-zinc-950 sm:w-72"
            >
            <button class="rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-medium hover:bg-zinc-50">
                Tim
            </button>
        </form>
    </div>

    <div class="overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm">
        <div class="hidden grid-cols-[1.1fr_1.3fr_1.4fr_1fr_auto] gap-4 border-b border-zinc-200 bg-zinc-50 px-4 py-3 text-xs font-semibold uppercase text-zinc-500 md:grid">
            <div>Website</div>
            <div>Email / Username</div>
            <div>Password</div>
            <div>OTP</div>
            <div></div>
        </div>

        @forelse ($accounts as $account)
            <div class="grid gap-4 border-b border-zinc-100 px-4 py-4 last:border-b-0 md:grid-cols-[1.1fr_1.3fr_1.4fr_1fr_auto] md:items-center">
                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Website</div>
                    <div class="font-medium">{{ $account['website_domain'] }}</div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Email / Username</div>
                    <div class="flex items-center gap-2">
                        <span class="break-all text-sm">{{ $account['login'] }}</span>
                        <button type="button" class="copy-btn rounded-md border border-zinc-300 px-2 py-1 text-xs font-medium hover:bg-zinc-50" data-copy="{{ $account['login'] }}">
                            Copy
                        </button>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Password</div>
                    <div class="flex items-center gap-2">
                        <input value="************" readonly class="password-field min-w-0 flex-1 rounded-md border border-zinc-300 bg-zinc-50 px-3 py-2 text-sm" data-secret="{{ $account['password'] }}">
                        <button type="button" class="reveal-btn rounded-md border border-zinc-300 px-2 py-2 text-xs font-medium hover:bg-zinc-50">
                            Hien
                        </button>
                        <button type="button" class="copy-password-btn rounded-md border border-zinc-300 px-2 py-2 text-xs font-medium hover:bg-zinc-50">
                            Copy
                        </button>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">OTP</div>
                    <div class="flex items-center gap-2" data-otp-url="{{ $account['otp_url'] }}">
                        <span class="otp-code rounded-md bg-zinc-100 px-3 py-2 font-mono text-sm font-semibold tracking-widest">{{ $account['otp'] }}</span>
                        <span class="otp-countdown w-8 text-xs text-zinc-500">{{ $account['seconds_remaining'] }}s</span>
                        <button type="button" class="copy-otp-btn rounded-md border border-zinc-300 px-2 py-2 text-xs font-medium hover:bg-zinc-50">
                            Copy
                        </button>
                    </div>
                </div>

                <div class="flex gap-2 md:justify-end">
                    @if (auth()->user()->is_admin)
                        <a href="{{ $account['edit_url'] }}" class="rounded-md border border-zinc-300 px-3 py-2 text-sm font-medium hover:bg-zinc-50">
                            Sua
                        </a>
                        <form method="POST" action="{{ $account['delete_url'] }}" onsubmit="return confirm('Xoa tai khoan nay?')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-md border border-red-200 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-50">
                                Xoa
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="px-4 py-12 text-center text-sm text-zinc-500">
                Chua co tai khoan nao.
            </div>
        @endforelse
    </div>
</x-layouts.app>
