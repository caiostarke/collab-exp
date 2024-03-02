<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\Attributes\On; 

new class extends Component {

    public $isOpenCreateOpportunity = false;
    public $isOpenDisplayOpportunities = false;    
    public $isOpenDisplayApplications = false;
    public $isOpenDisplayApplication = false;


    public $opportunitiesCount = '';

    public function openMenu($target) {
        switch ($target) {
            case 'isOpenCreateOpportunity':
                $this->isOpenDisplayApplications = false;

                $this->isOpenDisplayOpportunities = false;              
                $this->isOpenCreateOpportunity = true;

                break;
            case 'isOpenDisplayOpportunities':
                $this->isOpenDisplayApplications = false;
                $this->isOpenCreateOpportunity = false;
                $this->isOpenDisplayOpportunities = true;

                break;

            case 'isOpenDisplayApplications':
                $this->isOpenDisplayOpportunities = false;
                $this->isOpenCreateOpportunity = false;
                $this->isOpenDisplayApplications = true;

                break;

            default:
                $this->isOpenDisplayOpportunities = false;
                $this->isOpenCreateOpportunity = false;
                $this->isOpenDisplayApplications = false;


        }
    }

    #[On('updatedOpportunities')]
    public function mount() {
        $this->opportunitiesCount = Auth::user()->opportunities()->count();
    }
 
}; ?>
 
<div>
    @if (auth()->user()->isBusiness)
    <h1> {{ auth()->user()->name}} </h1>
    <div>
        <x-badge rounded="3xl" class="mt-2 mr-2" dark label="Business Account" /> 
        <x-badge flat black wire.model="opportunitiesCount" label="{{$opportunitiesCount}} Opportunites" />
    </div>


    <div class="mt-10 buttons">
        <x-button green class="mr-3 " wire:click="openMenu('isOpenCreateOpportunity')"> Create new Opportunity </x-button>
        <x-button sky class="mr-3 " wire:click="openMenu('isOpenDisplayOpportunities')"> Opportunities Created </x-button>
        <x-button class="mr-3" black wire:click="openMenu('isOpenDisplayApplications')" > Manage Applications</x-button>
    </div>
    

    @if ($isOpenCreateOpportunity)
        <x-button class="mt-5" label="Close Menu" right-icon="check" interaction="negative" wire:click="openMenu('aa')" />   `
        <livewire:create-opportunity />
    @elseif ($isOpenDisplayOpportunities)
        <x-button class="mt-5" label="Close Menu" right-icon="check" interaction="negative" wire:click="openMenu('aa')" />   `
        <livewire:display-opportunities />
    @elseif ($isOpenDisplayApplications)
        <x-button class="mt-5" label="Close Menu" right-icon="check" interaction="negative" wire:click="openMenu('aa')" />   `
        <livewire:displayapplications />
    @endif
    
    @else

    <h1> {{ auth()->user()->name}} </h1>
    <x-badge rounded="3xl" dark label="User Account" />

    <div class="mt-20 buttons">
        <x-button class="mr-2" green href="{{route('dev.explore')}}"> Search for opportunities </x-button>
        <x-button black wire:click="openMenu('isOpenDisplayApplications')"> Check Status of Applications</x-button>
    </div>

    @if ($isOpenDisplayApplications)
        <x-button class="mt-5" label="Close Menu" right-icon="check" interaction="negative" wire:click="openMenu('close')" />   `
        <livewire:displayapplications :isOpenDisplayApplications='$isOpenDisplayApplications'/>        
    @endif


    @endif
</div>
