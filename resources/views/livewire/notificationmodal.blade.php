<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
  
  public $isModalNotificationOpened;
  public $user;
  public $notifications;

  public function mount() {
    $this->user = Auth::user();
  }
  
  public function closeModal() {
    $this->dispatch('closeModal');
  }

}; ?>


<div class="fixed top-0 left-0 z-10 flex items-center justify-center w-full h-full bg-black bg-opacity-50 cursor-default">
    

    <!-- A basic modal dialog with title, body and one button to close -->
    <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" wire:click.away='closeModal()'>
      <div class="mt-3 text-center sm:mt-0 sm:text-left">
        
        <div class="relative mb-5">
          <span class="inline-block text-sm font-light ">{{ __('Notifications') }}</span>
          <div class="absolute bottom-0 left-0 w-10 bg-black border-b-2 border-red-500 border-b-30"></div>
        </div>
      
        @foreach ($notifications as $notification)
          <h3 class="py-2 text-sm font-medium leading-6 text-green-900 border-b border-gray-300">
            {{ $notification->message }}
          </h3>
        @endforeach
        

      </div>

    </div>    
    
</div>
