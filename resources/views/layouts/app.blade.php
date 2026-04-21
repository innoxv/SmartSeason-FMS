<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} – Field Monitoring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-950 dark:text-gray-100 font-inter antialiased min-h-screen transition-colors duration-200">

    {{-- Sidebar --}}
    <div class="flex min-h-screen">
    <aside id="sidebar" class="fixed h-full z-40 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col transform -translate-x-full sm:translate-x-0 transition-transform duration-200">
            {{-- Logo --}}
            <div class="px-6 py-4 border-b-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-green-600 rounded-md flex items-center justify-center shadow-lg">
<svg class="w-8 h-8 text-white" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">

    <!-- Left S -->
    <path d="M4.5 10.5C4.5 7.8 6.5 5.5 10 5.5C13.5 5.5 15.5 7.8 15.5 10.5C15.5 13 13 14.8 10 16C7 17.2 4.5 19.5 4.5 22C4.5 24.5 6.5 26.5 10 26.5C13.5 26.5 15.5 24.5 15.5 22"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>
    
    <!-- Center dot -->
    <circle cx="20" cy="16" r="1.3" fill="currentColor"/>
    
    <!-- Right S -->
    <path d="M35.5 10.5C35.5 7.8 33.5 5.5 30 5.5C26.5 5.5 24.5 7.8 24.5 10.5C24.5 13 27 14.8 30 16C33 17.2 35.5 19.5 35.5 22C35.5 24.5 33.5 26.5 30 26.5C26.5 26.5 24.5 24.5 24.5 22"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" fill="none"/>

    <!-- FMS text -->
    <text x="20" y="37" 
          text-anchor="middle" 
          font-size="10" 
          font-weight="500" 
          fill="currentColor"
          font-family="sans-serif"
          letter-spacing="1">
        FMS
    </text>

</svg>
                    </div>
                    <div>
                        <span class="text-gray-900 dark:text-white font-semibold text-sm leading-tight block">SmartSeason</span>
                        <span class="text-emerald-600 dark:text-emerald-400 text-xs font-medium">Field Monitor</span>
                    </div>
                </div>
            </div>


            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-4 space-y-1">
                @if(auth()->user()->isAdmin())
                <a wire:navigate href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a wire:navigate href="{{ route('admin.fields.index') }}" class="sidebar-link {{ request()->routeIs('admin.fields.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    All Fields
                </a>
                <a wire:navigate href="{{ route('admin.fields.create') }}" class="sidebar-link {{ request()->routeIs('admin.fields.create') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Add Field
                </a>
                <a wire:navigate href="{{ route('admin.agents.index') }}" class="sidebar-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Agents
                </a>
                @else
                <a wire:navigate href="{{ route('agent.dashboard') }}" class="sidebar-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a wire:navigate href="{{ route('agent.fields.index') }}" class="sidebar-link {{ request()->routeIs('agent.fields.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    My Fields
                </a>
                @endif
            </nav>

            {{-- Footer --}}
            <div class="px-3 py-4 border-t border-gray-200 dark:border-gray-800 space-y-1">
                <a wire:navigate href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-red-400 hover:bg-red-500/10 hover:text-red-300">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign out
                    </button>
                </form>
            </div>
    </aside>

    {{-- Overlay for mobile when sidebar is open --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-black/40 z-30 sm:hidden" style="display: none;"></div>

    {{-- Main Content --}}
    <main class="flex-1 ml-0 sm:ml-64 min-h-screen">
            {{-- Top Bar --}}
            <header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur border-b border-gray-200 dark:border-gray-800 px-8 py-4 sticky top-0 z-20 transition-colors duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <!-- Mobile hamburger to toggle sidebar -->
                        <button id="sidebar-toggle" class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors me-3" aria-label="Toggle sidebar">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div>
                            <h1 class="text-lg font-semibold text-gray-900 dark:text-white transition-colors duration-200">{{ $header ?? 'Dashboard' }}</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ now()->format('l, F j Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        {{-- Theme Toggle --}}
                        <button onclick="document.documentElement.classList.toggle('dark'); localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light'" class="text-gray-400 hover:text-emerald-500 transition-colors">
                            <span class="dark:hidden">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                            </span>
                            <span class="hidden dark:inline">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </span>
                        </button>

                        <div class="flex items-center gap-3 border-l border-gray-200 dark:border-gray-800 pl-4">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-medium text-gray-900 dark:text-white leading-tight truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role->label() }}</p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-emerald-100 border border-emerald-200 dark:bg-emerald-500/20 dark:border-emerald-500/30 flex items-center justify-center shrink-0">
                                <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    <script>
        // Fallback JS for sidebar toggle in case Alpine is not available.
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');

            if (!btn || !sidebar || !overlay) return;

            const setMobileClosed = () => {
                sidebar.classList.remove('translate-x-0');
                overlay.style.display = 'none';
            };

            const setDesktopOpen = () => {
                sidebar.classList.add('translate-x-0');
                overlay.style.display = 'none';
            };

            // Initial state based on viewport
            if (window.innerWidth >= 640) {
                setDesktopOpen();
            } else {
                setMobileClosed();
            }

            btn.addEventListener('click', function () {
                const isOpen = sidebar.classList.toggle('translate-x-0');
                overlay.style.display = isOpen ? 'block' : 'none';
            });

            overlay.addEventListener('click', function () {
                setMobileClosed();
            });

            // Keep state consistent on resize
            window.addEventListener('resize', function () {
                if (window.innerWidth >= 640) {
                    setDesktopOpen();
                } else {
                    setMobileClosed();
                }
            });
        });
    </script>
</body>
</html>
