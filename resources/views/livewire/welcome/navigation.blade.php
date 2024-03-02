<div class="z-10 p-6 sm:fixed sm:top-0 sm:right-0 text-end">
    @auth
        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Dashboard</a>
        <div x-data="{ showNotifications: false }">
            <button @click="showNotifications = !showNotifications">
                <i class="fas fa-bell" x-bind:class="{ 'text-yellow-500': showNotifications }"></i>
            </button>
        </div>
                
    @else
        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Log in</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="font-semibold text-gray-600 ms-4 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Register</a>
        @endif
    @endauth
</div>
