<x-card >
    <x-input 
    label="Search For businesses or Tags"
    placeholder="Tags or Businesses"
    wire:model='query'
    />

    <x-button class="mt-5" sky label="Search" right-icon="search" interaction="negative" wire:click='searchOpportunities'/>
</x-card>