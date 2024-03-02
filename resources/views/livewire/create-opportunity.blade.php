<?php

use App\Models\Opportunities;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    
    public $title = '';
    public $description = '';
    public $requirements = '';


    public function createOpportunity() {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'requirements' => ['required', 'string', 'max:255'],
        ]);

        $validated['user_id'] = Auth::user()->id;

        $opportunity = Opportunities::create($validated);

        
        session()->flash('status', 'Opportunity created successfully!');

        $this->reset(['title', 'description', 'requirements']);

        $this->dispatch('updatedOpportunities');
    }   

}; ?>

<form class="mt-5" wire:submit="createOpportunity">

    <!-- Title -->
    <div>
        <x-input-label for="title" :value="__('Title of your opportunity')" />
        <x-text-input wire:model="title" id="title" class="block w-full mt-1" type="text" name="title" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <!-- description -->
    <div class="mt-4">
        <x-input-label for="description" :value="__('Description')" />
        <x-text-input wire:model="description" id="description" class="block w-full mt-1" type="text" name="description" required autocomplete="description" />
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    
    <!-- requirements -->
    <div class="mt-4">
        <x-input-label for="requirements" :value="__(' Requirements' )" />
        <x-text-input wire:model="requirements" id="skills" class="block w-full mt-1" type="text" name="skills" required autocomplete="username" />
        <x-input-error :messages="$errors->get('requirements')" class="mt-2" />
    </div>
    
    <div class="flex items-center justify-end mt-4">

        <x-primary-button class="ms-4">
            {{ __('Create Opportunity') }}
        </x-primary-button>
    </div>

    @if (session('status'))
        <div class="px-3 py-2 mt-5 text-white bg-green-400 rounded alert alert-success">
            {{ session('status')}}
        </div>
    @endif
    

</form>   
