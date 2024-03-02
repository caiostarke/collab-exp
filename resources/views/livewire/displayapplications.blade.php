<?php

use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Auth;

use Livewire\Volt\Component;

new class extends Component {
    public $applications = [];  
    public $user;
    public $isOpenDisplayApplications;

    public $isOpenDisplayApplication;
    public $applicationID;

    #[On('updatedOpportunities')]
    public function mount() {
        $this->user = Auth::user();

        $this->applications = collect();
        if ($this->user->isBusiness == true ) {
            $opportunities = $this->user->opportunities;
            foreach ($opportunities as $opportunity) {
                $this->applications = $this->applications->merge($opportunity->applications);  
            }
        } else {
            $this->applications = $this->user->applications;
        }
    }

    #[On('applicationUpdated')]
    public function applicationUpdated($message) {
        $this->isOpenDisplayApplication = false;
        
        session()->flash('status', $message);
    }

    public function OpenDisplayApplication($applicationID) {
        $this->applicationID = $applicationID;   
        
        $this->isOpenDisplayApplication = true;   
    }

}; ?>

<div>

    @if (session('status'))
        <div class="px-3 py-2 mt-5 text-white bg-green-400 rounded alert alert-success">
            {{ session('status')}}
        </div>
    @endif

    @if ($isOpenDisplayApplication)
        <livewire:displayapplication :applicationID='$applicationID' />
    
    @else 
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 mt-7 container__opportunities">

            @foreach ($applications as $application)
                <x-card wire:key='{{$application->id}}' class="w-full pl-5">
                    
                    <h1 class="text-base font-medium"> {{$application->message}}</h1>
                    <p class="mt-3 text-sm"> <span class="mb-5 text-red-500 text-xm"> Description </span> <br /> {{$application->status}} </p>
        
        
                    <x-button green wire.prevent class="mt-5 mr-2" wire:click="OpenDisplayApplication('{{$application->id}}')" > See details </x-button> 
            
                </x-card>
            @endforeach

        </div>
    @endif

</div>
