<x-layouts.app title="Tài khoản dùng chung">
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex rounded-md border border-emerald-200 bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                {{ auth()->user()->is_admin ? 'Quyền admin' : 'Chỉ xem' }}
            </div>
            <h1 class="text-2xl font-semibold tracking-tight">Tài khoản dùng chung</h1>
            <p class="mt-1 text-sm text-zinc-600">{{ $accounts->count() }} tài khoản. Password và 2FA secret được mã hóa khi lưu.</p>
        </div>

        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
            <form method="GET" action="{{ route('accounts.index') }}" class="flex w-full rounded-md border border-zinc-200 bg-white p-1 shadow-sm sm:w-auto">
                <input
                    name="q"
                    value="{{ $query }}"
                    placeholder="Tìm website hoặc email"
                    class="min-w-0 flex-1 rounded-md border-0 bg-transparent px-3 py-1.5 text-sm outline-none sm:w-72"
                >
                <button class="rounded-md bg-zinc-950 px-3.5 py-1.5 text-sm font-semibold text-white hover:bg-zinc-800">
                    Tìm
                </button>
            </form>

            @if (auth()->user()->is_admin)
                <a href="{{ route('accounts.create') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                    Thêm tài khoản
                </a>
            @endif
        </div>
    </div>

    <div class="overflow-hidden rounded-md border border-zinc-200 bg-white shadow-sm">
        <div class="hidden grid-cols-[1.1fr_1.35fr_1.45fr_1.1fr_auto] gap-3 border-b border-zinc-200 bg-zinc-50 px-4 py-2.5 text-xs font-semibold uppercase text-zinc-500 md:grid">
            <div>Website</div>
            <div>Email / Username</div>
            <div>Password</div>
            <div>OTP 2FA</div>
            <div></div>
        </div>

        @forelse ($accounts as $account)
            <div class="grid gap-3 border-b border-zinc-100 px-4 py-3 transition last:border-b-0 hover:bg-zinc-50/70 md:grid-cols-[1.1fr_1.35fr_1.45fr_1.1fr_auto] md:items-center">
                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Website</div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        <a
                            href="{{ $account['website_url'] }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="break-all text-sm font-semibold text-zinc-950 underline decoration-zinc-300 underline-offset-4 hover:text-emerald-700 hover:decoration-emerald-500"
                        >
                            {{ $account['website_domain'] }}
                        </a>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Email / Username</div>
                    <div class="flex items-center gap-2">
                        <span class="break-all text-sm">{{ $account['login'] }}</span>
                        <button type="button" class="copy-btn rounded-md border border-zinc-300 bg-white px-2 py-1 text-xs font-semibold text-zinc-700 hover:border-zinc-400 hover:bg-zinc-50" data-copy="{{ $account['login'] }}">
                            Copy
                        </button>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">Password</div>
                    <div class="flex items-center gap-2" data-password-url="{{ $account['password_url'] }}">
                        <input value="***" readonly class="password-field min-w-0 flex-1 rounded-md border border-zinc-200 bg-zinc-50 px-3 py-1.5 font-mono text-sm text-zinc-700" data-hidden-value="***">
                        <button type="button" class="reveal-btn rounded-md border border-zinc-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-zinc-700 hover:border-zinc-400 hover:bg-zinc-50">
                            Show
                        </button>
                        <button type="button" class="copy-password-btn rounded-md border border-zinc-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-zinc-700 hover:border-zinc-400 hover:bg-zinc-50">
                            Copy
                        </button>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-semibold uppercase text-zinc-500 md:hidden">OTP 2FA</div>
                    <div class="flex items-center gap-2" data-otp-url="{{ $account['otp_url'] }}">
                        <span class="otp-code rounded-md bg-emerald-50 px-3 py-1.5 font-mono text-sm font-bold tracking-widest text-emerald-700 ring-1 ring-emerald-200">{{ $account['otp'] }}</span>
                        <span class="otp-countdown w-8 text-xs font-medium text-zinc-500">{{ $account['seconds_remaining'] }}s</span>
                        <button type="button" class="copy-otp-btn rounded-md border border-emerald-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                            Copy
                        </button>
                    </div>
                </div>

                <div class="flex gap-2 md:justify-end">
                    @if (auth()->user()->is_admin)
                        <a href="{{ $account['edit_url'] }}" class="rounded-md border border-zinc-300 bg-white px-2.5 py-1.5 text-sm font-semibold text-zinc-700 hover:bg-zinc-50">
                            Sửa
                        </a>
                        <form method="POST" action="{{ $account['delete_url'] }}" onsubmit="return confirm('Xóa tài khoản này?')">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-md border border-red-200 bg-white px-2.5 py-1.5 text-sm font-semibold text-red-700 hover:bg-red-50">
                                Xóa
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
                <div class="mt-3 text-sm font-semibold text-zinc-800">Chưa có tài khoản nào</div>
                <p class="mt-1 text-sm text-zinc-500">Admin có thể thêm tài khoản dùng chung đầu tiên.</p>
            </div>
        @endforelse
    </div>
</x-layouts.app>
