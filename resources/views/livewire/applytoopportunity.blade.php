<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Opportunities;
use App\Models\Application;
use Livewire\Attributes\On; 


use Livewire\Volt\Component;

new class extends Component {

    public $opportunityID;
    public $message = '';

    public function closeModal() {
        $this->dispatch('closeModal');
    }

    public function apply() {        
        $validated = $this->validate([
            'message' => ['required', 'string', 'max:255'],
        ]);

        $opportunity = Opportunities::find($this->opportunityID);
        
        $user = Auth::user();

        if ($user->applications()->where('opportunity_id', $opportunity->id)->exists()) {
          $this->dispatch('errorAlreadyApplied');
            return;
        }


        
        if ($opportunity) {
            $validated['opportunity_id'] = $opportunity->id; 
            $validated['user_id'] = Auth::user()->id; 
            $application = Application::create($validated);


            $this->dispatch('closeModal');
            $this->dispatch('userApplied');

            $this->dispatch('applicationApplied');

        }

    }
}; ?>

<div>

    <form class="mt-5" wire:submit='apply'>

        <div class="mt-6 " x-data="{ open: true }">
    
            <!-- Dialog (full screen) -->
            <div class="fixed top-0 left-0 flex items-center justify-center w-full h-full bg-black bg-opacity-50" x-show="open"  >
      
              <!-- A basic modal dialog with title, body and one button to close -->
              <div class="h-auto p-4 mx-2 text-left bg-white rounded shadow-xl md:max-w-xl md:p-6 lg:p-8 md:mx-0" wire:click.away='closeModal()'>
                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                <span class="text-xs text-red-400 "> Opportunity id: {{$opportunityID}} </span> <br />
                  <h3 class="font-medium leading-6 text-gray-900 text-md">
                    Type the text u would like the owner of this opportunity read. 
                  </h3>
      
                  <div class="mt-2">
                    <x-input-label for="message" :value="__('Message')" />
                    <x-text-input wire:model="message" id="message" class="block w-full mt-1" type="text" name="message" required autofocus autocomplete="text" />
                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                </div>
              </div>
      
                <!-- One big close button.  --->
                <div class="mt-5 sm:mt-6">
            
                  <x-primary-button
                  x-on:click="$wireui.confirmDialog({
                  title: 'Are you Sure?',
                  description: 'Save the information?',
                  icon: 'question',
                  accept: {
                      label: 'Yes, save it',
                      execute: () => window.$wireui.notify({
                          'icon': 'success',
                          'title': 'You confirmed',
                      })
                  },
                  reject: {
                      label: 'No, cancel',
                      execute: () => window.$wireui.notify({
                          'icon': 'error',
                          'title': 'You not confirmed',
                      })
                  }
              })"
                  info>
                  {{ __('Apply!') }}
              </x-primary-button>


                <x-button class="ml-2" wire:click='closeModal()' black > Close modal! </x-button>
                </div>
      
              </div>    
            </div>
          </div>
    
    </form>
    

  
</div>
