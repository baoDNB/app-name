<x-layouts.app title="{{ $mode === 'create' ? 'Thêm tài khoản' : 'Sửa tài khoản' }}">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 inline-flex rounded-md border border-zinc-200 bg-white px-2.5 py-1 text-xs font-semibold text-zinc-600 shadow-sm">
                {{ $mode === 'create' ? 'Tạo mới' : 'Cập nhật' }}
            </div>
            <h1 class="text-3xl font-semibold tracking-tight">{{ $mode === 'create' ? 'Thêm tài khoản' : 'Sửa tài khoản' }}</h1>
            <p class="mt-2 text-sm text-zinc-600">
                Lưu thông tin đăng nhập dùng chung và setup key 2FA để app tự tạo OTP.
            </p>
        </div>
        <a href="{{ route('accounts.index') }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-700 shadow-sm hover:bg-zinc-50">
            Quay lại
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
        <form
            method="POST"
            action="{{ $mode === 'create' ? route('accounts.store') : route('accounts.update', $account) }}"
            class="rounded-md border border-zinc-200 bg-white shadow-sm"
        >
            @csrf
            @if ($mode === 'edit')
                @method('PUT')
            @endif

            <div class="border-b border-zinc-200 px-6 py-4">
                <h2 class="text-sm font-semibold text-zinc-950">Thông tin đăng nhập</h2>
                <p class="mt-1 text-xs text-zinc-500">Tất cả trường nhạy cảm sẽ được mã hóa khi lưu.</p>
            </div>

            <div class="space-y-5 p-6">
                <div>
                    <label for="website_domain" class="mb-1 block text-sm font-medium text-zinc-700">Website domain</label>
                    <input
                        id="website_domain"
                        name="website_domain"
                        value="{{ old('website_domain', $account->website_domain) }}"
                        placeholder="github.com"
                        required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                    >
                    @error('website_domain')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="login" class="mb-1 block text-sm font-medium text-zinc-700">Username hoặc email</label>
                    <input
                        id="login"
                        name="login"
                        value="{{ old('login', $account->login) }}"
                        placeholder="team@example.com"
                        required
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                    >
                    @error('login')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-zinc-700">Password đăng nhập website</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        @if ($mode === 'create') required @endif
                        autocomplete="new-password"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                    >
                    @if ($mode === 'edit')
                        <p class="mt-1 text-xs text-zinc-500">Để trống nếu không đổi password.</p>
                    @else
                        <p class="mt-1 text-xs text-zinc-500">Đây là password của website cần lưu, không phải password đăng nhập app này.</p>
                    @endif
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="two_factor_secret" class="mb-1 block text-sm font-medium text-zinc-700">2FA setup key / manual key</label>
                    <input
                        id="two_factor_secret"
                        name="two_factor_secret"
                        type="password"
                        placeholder="Ví dụ: JBSWY3DPEHPK3PXP"
                        @if ($mode === 'create') required @endif
                        autocomplete="off"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 font-mono text-sm outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                    >
                    @if ($mode === 'edit')
                        <p class="mt-1 text-xs text-zinc-500">Secret gốc không hiển thị lại sau khi lưu. Nhập setup key mới nếu cần thay.</p>
                    @else
                        <p class="mt-1 text-xs text-zinc-500">Lấy từ màn QR/setup 2FA của website. Không nhập mã OTP 6 số vào đây.</p>
                    @endif
                    @error('two_factor_secret')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-zinc-200 bg-zinc-50 px-6 py-4">
                <a href="{{ route('accounts.index') }}" class="rounded-md border border-zinc-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50">
                    Hủy
                </a>
                <button class="rounded-md bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                    Lưu
                </button>
            </div>
        </form>

        <aside class="self-start rounded-md border border-zinc-200 bg-white shadow-sm">
            <div class="border-b border-zinc-200 px-5 py-4">
                <h2 class="text-sm font-semibold text-zinc-950">Ghi chú về 2FA</h2>
                <p class="mt-1 text-xs text-zinc-500">Phần này giúp tránh nhập nhầm OTP và secret.</p>
            </div>
            <div class="space-y-4 p-5 text-sm text-zinc-600">
                <div class="rounded-md bg-emerald-50 p-3 ring-1 ring-emerald-100">
                    <div class="font-medium text-zinc-800">Nhập vào đây</div>
                    <p class="mt-1">Setup key/manual key lấy từ màn bật 2FA của website.</p>
                </div>
                <div class="rounded-md bg-amber-50 p-3 ring-1 ring-amber-100">
                    <div class="font-medium text-zinc-800">Không nhập</div>
                    <p class="mt-1">Mã OTP 6 số đang thấy trong Authenticator. Mã đó chỉ để verify/login.</p>
                </div>
                <div>
                    <div class="mb-2 text-xs font-semibold uppercase text-zinc-500">Ví dụ setup key</div>
                    <div class="rounded-md bg-zinc-950 p-3 font-mono text-xs text-zinc-100">
                        secret=JBSWY3DPEHPK3PXP
                    </div>
                </div>
            </div>
        </aside>
    </div>
</x-layouts.app>
