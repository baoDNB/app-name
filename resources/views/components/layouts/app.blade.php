<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Shared Accounts' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased">
        <div class="min-h-screen">
            @auth
                <header class="border-b border-zinc-200 bg-white">
                    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-2 sm:px-6 lg:px-8">
                        <a href="{{ route('accounts.index') }}" class="text-base font-semibold tracking-tight">
                            Shared Accounts
                        </a>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="hidden text-zinc-600 sm:inline">{{ auth()->user()->email }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-medium text-zinc-700 hover:bg-zinc-50">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                </header>
            @endauth

            <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
