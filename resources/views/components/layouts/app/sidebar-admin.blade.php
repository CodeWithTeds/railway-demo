<div class="h-screen border-r border-zinc-200 bg-zinc-50">
    <div class="flex h-16 items-center px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>
    </div>
    
    <div class="px-3 py-2">
        <h2 class="mb-2 px-4 text-lg font-semibold tracking-tight">{{ __('Platform') }}</h2>
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-zinc-200' : 'hover:bg-zinc-100' }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                {{ __('Dashboard') }}
            </a>
            
            <a href="{{ route('materials.index') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('materials.*') ? 'bg-zinc-200' : 'hover:bg-zinc-100' }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                {{ __('Materials') }}
            </a>
            
            <a href="{{ route('products.index') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'bg-zinc-200' : 'hover:bg-zinc-100' }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                {{ __('Products') }}
            </a>
            
            @if(auth()->check() && auth()->user()->isAdmin())
            <a href="{{ route('admin.suppliers.index') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.suppliers.*') ? 'bg-zinc-200' : 'hover:bg-zinc-100' }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                {{ __('Suppliers') }}
            </a>
            @endif
            
            <a href="{{ route('admin.pos') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.pos') ? 'bg-zinc-200' : 'hover:bg-zinc-100' }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                {{ __('POS') }}
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-zinc-200' : 'hover:bg-zinc-100' }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><rect x="7" y="7" width="3" height="3"></rect><rect x="14" y="7" width="3" height="3"></rect><rect x="7" y="14" width="3" height="3"></rect><rect x="14" y="14" width="3" height="3"></rect></svg>
                {{ __('Orders') }}
            </a>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-zinc-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-zinc-300 flex items-center justify-center text-sm font-medium">
                    {{ auth()->user()->initials() }}
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-1">
                <a href="{{ route('profile.edit') }}" class="p-2 rounded-md hover:bg-zinc-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 rounded-md hover:bg-zinc-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>