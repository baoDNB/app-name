<x-layouts.app title="Đăng nhập">
    <div class="mx-auto grid min-h-[70vh] max-w-5xl items-center gap-8 lg:grid-cols-[1fr_26rem]">
        <section class="hidden lg:block">
            <div class="max-w-xl">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-md bg-zinc-950 text-base font-semibold text-white">
                    SA
                </div>
                <h1 class="text-4xl font-semibold tracking-tight text-zinc-950">Shared Accounts</h1>
                <p class="mt-4 max-w-lg text-base leading-7 text-zinc-600">
                    Nơi lưu tài khoản dùng chung, password và OTP 2FA cho team. Mọi thứ nằm trong một màn hình để copy nhanh khi cần đăng nhập.
                </p>
                <div class="mt-8 grid max-w-lg grid-cols-3 gap-3">
                    <div class="rounded-md border border-zinc-200 bg-white p-4 shadow-sm">
                        <div class="text-sm font-semibold text-zinc-950">Encrypted</div>
                        <div class="mt-1 text-xs text-zinc-500">Password và secret</div>
                    </div>
                    <div class="rounded-md border border-zinc-200 bg-white p-4 shadow-sm">
                        <div class="text-sm font-semibold text-zinc-950">TOTP</div>
                        <div class="mt-1 text-xs text-zinc-500">Đổi mới 30 giây</div>
                    </div>
                    <div class="rounded-md border border-zinc-200 bg-white p-4 shadow-sm">
                        <div class="text-sm font-semibold text-zinc-950">Admin</div>
                        <div class="mt-1 text-xs text-zinc-500">Thêm sửa xóa</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-md border border-zinc-200 bg-white p-6 shadow-sm">
            <div class="mb-6">
                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-md bg-zinc-950 text-sm font-semibold text-white lg:hidden">
                    SA
                </div>
                <h2 class="text-xl font-semibold tracking-tight">Đăng nhập</h2>
                <p class="mt-1 text-sm text-zinc-500">Sử dụng tài khoản nội bộ để truy cập danh sách.</p>
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
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
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
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2.5 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-700">
                    <input type="checkbox" name="remember" value="1" class="rounded border-zinc-300 text-emerald-600">
                    Ghi nhớ đăng nhập
                </label>

                <button class="w-full rounded-md bg-emerald-600 px-4 py-2.5 font-semibold text-white shadow-sm hover:bg-emerald-700">
                    Đăng nhập
                </button>
            </form>

            <div class="mt-5 rounded-md bg-zinc-50 p-3 text-xs text-zinc-600">
                Test nhanh: admin@example.com / password
            </div>
        </section>
    </div>
</x-layouts.app>
