<?php

use App\Models\Opportunities;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;



use Livewire\Volt\Component;

new class extends Component {
    
    public $applicationID;
    public $application;
    public $message;
    public $relatedOpportunity;

    public $updateMode = false;

    public function mount() {
        $this->application = Application::find($this->applicationID);
        $this->relatedOpportunity = Opportunities::find($this->application->opportunity_id); 
    }

    public function delete() {
        if ($this->application->user_id == Auth::user()->id) {
            $this->application->delete();
            $this->dispatch('applicationUpdated', 'Application Canceled!');
        }
    }

    public function isUpdateMode() {
        if ($this->application->user_id == Auth::user()->id) {
            $this->updateMode = !$this->updateMode;
        }
    }

    public function save() {
        $validated = $this->validate([
            'message' => ['required', 'string'],
        ]);

        $this->application->message = $validated['message'];
        $this->application->save();
        
        $this->dispatch('applicationUpdated', 'Text updated Successfully! ;)');
    }

    public function updateStatusApplication($status) {
        $user = Auth::user();

        if (!$user->isBusiness || $this->application->opportunity->user_id !=  $user->id) {
            return;
        }

        if ($status == 'accepted' || $status == 'rejected') {
            if ($this->application->status == $status) {
                session()->flash('error', 'This status is already defined.');
                return;
            } 
            $this->application->save();
            
            $this->application->status = $status;
            $appliedUser = User::find($this->application->user_id);

            $notificationService = new NotificationService(); 
            
            if ($status == 'accepted') {
                $notificationService->sendNotification($appliedUser, 'Congratulations!! One of yours applications was accepted, check on your dashboard ;)).');
            } else {
                $notificationService->sendNotification($appliedUser, 'Hey bro ;( Not good news... One of your applications was rejected... But keep climbing bro :D');
            }

            $this->dispatch('applicationUpdated', 'Status updated Succesfully!)');  
        }

    }

}; ?>

<div>
    
    <x-card class="flex flex-col px-5 pt-5 mt-3 text-left">

        @if (session('error'))
            <div class="px-4 py-2 mb-5 font-bold text-white bg-red-500 rounded"> 
                {{ session('error') }}
            </div>
        @endif


        {{-- Title of Opportunity --}}
        <section class="mb-5 opportunity__title">
            <p class="text-sm text-red-400">  Title of Opportunity <p> 
            <h1 class="text-lg font-bold">{{ $relatedOpportunity->title }}</h1>
        </section>
            
        {{-- Application Message --}}
        <section class="mb-5 application__message">
            <p class="text-sm text-red-400">  Text of Application <p> 
            @if ($updateMode)
                <form wire:submit='save'>
                    <x-input wire:model="message"  name="message" class="mt-2" placeholder="{{$application->message}}" value="{{$application->message}}" ></x-input>
                    <x-primary-button green class="mt-3"> Save </x-primary-button>    
                </form>
            @else 
                <h1 class="text-lg font-bold">{{ $application->message }}</h1>
            @endif

        </section>
    
        {{-- Status of Application --}}
        <section class="mb-5 application__status">
            <p class="text-sm text-red-400">  Status of Application <p> 
            <h1 class="text-lg font-bold">{{ $application->status }}</h1>
        </section>

        {{-- Application Date --}}
        <section class="mb-5 application__date">
            <p class="text-sm text-red-400">  Application Date <p> 
            <h1 class="text-lg font-bold">{{ $application->created_at }}</h1>
        </section>

        {{-- Action Buttons --}}
        @if (!auth()->user()->isBusiness)
            <section class="action__buttons">
                <x-button wire:confirm="Are u sure?"  red class="mr-3" wire:click='delete()' x-on:click="$wire.$refresh()"> Delete Application </x-button>
                @if ($updateMode)
                    <x-button green wire:click='isUpdateMode()'> Close Update Mode </x-button>
                @else 
                    <x-button green wire:click='isUpdateMode()'> Update text </x-button>
                @endif
            </section>
        
        @else
            
            <section class="action__buttons">
                <x-button wire:confirm="Are u sure?"  green class="mr-3" wire:click="updateStatusApplication('accepted')" x-on:click="$wire.$refresh()"> Accept Application </x-button>
                <x-button wire:confirm="Are u sure?"  red class="mr-3" wire:click="updateStatusApplication('rejected')" x-on:click="$wire.$refresh()"> Reject Application </x-button>
            </section>

        @endif

    </x-card>
    
</div>
