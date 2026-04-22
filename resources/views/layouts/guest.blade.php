<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} – {{ $title ?? 'Welcome' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @livewireStyles
    <script>
        function applyTheme() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        applyTheme();
        document.addEventListener('livewire:navigated', applyTheme);
    </script>
    <style>
        .livewire-progressive-bar {
            background-color: #10b981 !important;
            height: 2px !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 font-inter antialiased min-h-screen flex items-center justify-center p-4 transition-colors duration-200">
    <!-- Top Navigation Header -->
    <header class="fixed top-0 left-0 right-0 p-6 flex items-center justify-between z-30 transition-all duration-300">
        <a href="/" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-600 rounded-md flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-105 group-hover:shadow-emerald-500/30 transition-all duration-300">
                <svg class="w-7 h-7 text-white" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Left S -->
                    <path d="M4.5 10.5C4.5 7.8 6.5 5.5 10 5.5C13.5 5.5 15.5 7.8 15.5 10.5C15.5 13 13 14.8 10 16C7 17.2 4.5 19.5 4.5 22C4.5 24.5 6.5 26.5 10 26.5C13.5 26.5 15.5 24.5 15.5 22"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
                    <!-- Center dot -->
                    <circle cx="20" cy="16" r="1.3" fill="currentColor"/>
                    <!-- Right S -->
                    <path d="M35.5 10.5C35.5 7.8 33.5 5.5 30 5.5C26.5 5.5 24.5 7.8 24.5 10.5C24.5 13 27 14.8 30 16C33 17.2 35.5 19.5 35.5 22C35.5 24.5 33.5 26.5 30 26.5C26.5 26.5 24.5 24.5 24.5 22"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
                    <!-- FMS text -->
                    <text x="20" y="39" text-anchor="middle" font-size="12" font-weight="500" fill="currentColor" font-family="sans-serif" letter-spacing="1">FMS</text>
                </svg>
            </div>
            <div class="hidden sm:flex flex-col leading-none">
                <span class="text-sm font-bold tracking-tight text-gray-800 dark:text-white">SmartSeason</span>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Field Monitoring System</span>
            </div>
        </a>

        <button onclick="document.documentElement.classList.toggle('dark'); localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light'" 
                class="p-2.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-md text-gray-400 hover:text-emerald-500 hover:border-emerald-500/30 transition-all duration-300 shadow-sm">
            <span class="dark:hidden">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </span>
            <span class="hidden dark:inline">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </span>
        </button>
    </header>

    {{-- Background decoration --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-green-500/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-500/3 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-sm relative z-10 py-12">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
