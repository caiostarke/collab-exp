<div>  

    @if (session('error'))
        <div class="px-3 py-2 mt-5 text-white bg-red-400 rounded alert alert-error">
            {{ session('error')}}
        </div>
      @endif


    <div left-icon="check" class="fixed z-10 px-6 py-5 text-sm text-black transform -translate-x-1/2 bg-green-200 rounded shadow cursor-default top-12 left-1/2 opacity-90" x-data="{ shown: false, timeout: null }"
        x-init="@this.on('applicationApplied', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 5000); })"
        x-show.transition.opacity.out.duration.1500ms="shown"
        style="display: none;">
        {{ __('You Applied successfully. Check your dashboard to be up to date with the status of application   .') }}
    </div>  

    @if (session('notFound'))
        <span class="ml-2 text-sm text-red-500 opacity-70"> Nothing found. </span>
    @endif

    @if ($opts)
        <span class="ml-2 text-sm opacity-50"> {{ count($opts)}} results found. </span>

        <div class="grid grid-cols-1 gap-4 mb-5 sm:grid-cols-2 md:grid-cols-2 lg:sm:grid-cols-3 mt-7 container__opportunities">
            @foreach ($opts as $opportunity)
                <x-card wire:key="{{$opportunity['id']}}" class="px-5 py-5 sm:px-6 sm:py-6 md:px-6 md:py-6">
                    
                    <h1 class="text-base font-medium"> {{$opportunity['title']}}</h1>
                    <p class="mt-3 text-sm"> <span class="mb-5 text-red-500 text-xm"> Description </span> <br /> {{ $opportunity['description'] }} </p>

                    <p class="mt-3 text-sm"><span class="mb-5 text-red-500 text-xm"> Requirements </span>: <br />{{ $opportunity['requirements'] }} </p>

                    <x-button green class="mt-5 mr-2"> See details </x-button> 
                    
                    <x-button sky class="mt-5" wire:click="openModal({{$opportunity['id']}})" > Apply ;) </x-button> 
                        
                </x-card>
            @endforeach
        </div>

        @else 

        <div class="grid grid-cols-1 gap-4 mb-5 sm:grid-cols-2 md:grid-cols-2 lg:sm:grid-cols-3 mt-7 container__opportunities">
            @foreach ($opportunities as $opportunity)
                <x-card wire:key="{{$opportunity['id']}}" class="px-5 py-5 sm:px-6 sm:py-6 md:px-6 md:py-6">
                    
                    <h1 class="text-base font-medium"> {{$opportunity->title}}</h1>
                    <p class="mt-3 text-sm"> <span class="mb-5 text-red-500 text-xm"> Description </span> <br /> {{ $opportunity['description'] }} </p>

                    <p class="mt-3 text-sm"><span class="mb-5 text-red-500 text-xm"> Requirements </span>: <br />{{ $opportunity['requirements'] }} </p>

                    <x-button green class="mt-5 mr-2"> See details </x-button> 
                    
                    @if (auth()->user()->name == $opportunity->user->name)
                        <x-button black warning wire:confirm="Are you sure you want to delete this post?" label="Delete" wire:click="deleteOportunitty('{{$opportunity['id']}}')" />
                    @else 
                        <x-button sky class="mt-5" wire:click="openModal({{$opportunity['id']}})" > Apply ;) </x-button> 
                    @endif
                        
                </x-card>
            @endforeach
        </div>


    @endif
    
{{ $opportunities->links() }}

    @if ($modalOpened)
        <livewire:applytoopportunity :opportunityID="$actualOpportunityID" />
    @endif




</div>

