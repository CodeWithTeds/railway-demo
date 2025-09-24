<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    @livewireStyles
    
    <!-- Scripts -->
    <script src="{{ url('/js/app.js') }}" defer></script>
</head>
<body class="h-full font-sans antialiased bg-white dark:bg-zinc-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="hidden lg:block">
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isStaff()))
                <x-layouts.app.sidebar-admin :title="$title ?? null" />
            @else
                <x-layouts.app.sidebar-client :title="$title ?? null" />
            @endif
        </aside>

        <!-- Mobile sidebar (hidden by default) -->
        <div class="sidebar-mobile fixed inset-0 z-40 hidden lg:hidden">
            <div class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm" onclick="this.parentElement.classList.add('hidden')"></div>
            <div class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-zinc-900 shadow-lg">
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isStaff()))
                    <x-layouts.app.sidebar-admin :title="$title ?? null" />
                @else
                    <x-layouts.app.sidebar-client :title="$title ?? null" />
                @endif
            </div>
        </div>

        <!-- Mobile menu button -->
        <div class="lg:hidden fixed top-0 left-0 right-0 z-30 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 p-4 flex items-center justify-between">
            <button type="button" class="p-2 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800" onclick="document.querySelector('.sidebar-mobile').classList.toggle('hidden')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>
            </button>
            
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-zinc-300 dark:bg-zinc-700 flex items-center justify-center text-sm font-medium">
                    {{ auth()->user()->initials() }}
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <main class="flex-1 overflow-y-auto pt-16 lg:pt-0">
            <div class="p-4">
                {{ $slot }}
            </div>
        </main>
    </div>
    
    @fluxScripts
    @livewireScripts
</body>
</html>
