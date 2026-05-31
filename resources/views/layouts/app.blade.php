<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @livewireStyles
</head>

<body>
    <header>
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-4">

            <a href="/" class="text-md font-bold whitespace-nowrap">
                Nama Web
            </a>

            <nav class="flex flex-wrap items-center justify-center gap-4 text-sm sm:text-base">
                <a href="/" class="hover:underline">Home</a>
                <a href="/transaction" class="hover:underline">Transaksi</a>
            </nav>

            <div class="flex items-center">
                <flux:button x-data x-on:click="$flux.dark = !$flux.dark" icon="moon" variant="subtle"
                    aria-label="Toggle dark mode" />
            </div>

        </div>
    </header>

    <div class="mx-auto max-w-7xl px-4 py-6">
        {{ $slot }}
    </div>

    <flux:separator class="mt-10" />

    <footer class="py-8">
        <div class="mx-auto max-w-7xl px-4">
            <div class="flex flex-col items-center justify-between gap-6 md:flex-row">

                <div>
                    <flux:heading size="lg">TopUp Game</flux:heading>
                    <flux:text class="text-zinc-500 pt-2">
                        © {{ date('Y') }} TopUp Game. All rights reserved.
                    </flux:text>
                </div>

                <div class="text-center md:text-right">
                    <flux:text class="mb-2 text-zinc-500">
                        Secure Payment By
                    </flux:text>

                    <img src="{{ asset('products/Midtrans.png') }}" alt="Midtrans" class="h-8 w-auto">
                </div>

            </div>
        </div>
    </footer>
    @fluxScripts
    @livewireScripts
</body>

</html>
