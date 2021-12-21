<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

    <!-- Styles -->
    @moveStyles()
    <link rel="stylesheet" href="{{ ! empty(config('app.name')) ? mix('css/app.css') : asset('css/app.css') }}">

    <livewire:styles>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>

</head>
<body class="font-sans antialiased" x-data="{ mobileMenuOpen: false, sidebarMenuOpen: true }">

    <div class="h-screen flex overflow-hidden bg-gray-100">

        @if (! ($withoutSidebar ?? false))
        <x-move-sidebar />
        @endif

        <div class="flex flex-col w-0 flex-1 h-screen overflow-hidden">
            <div class="relative z-5 flex-shrink-0 flex h-16 bg-white shadow">
                <x-move-header />
            </div>

            <main class="flex-1 relative overflow-y-auto focus:outline-none" tabindex="0">
                <div class="pt-2 pb-6 md:py-6">
                    @if ($header ?? null)
                    <div class="px-4 sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">
                            {{ $header }}
                        </h1>
                    </div>
                    @endif
                    <div class="mx-auto px-4 sm:px-6 md:px-8">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    @moveScripts()
    <livewire:scripts>
    @stack('scripts')
    @stack('modals')
</body>
</html>
