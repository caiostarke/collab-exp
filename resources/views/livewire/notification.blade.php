<?php

use Livewire\Volt\Component;

new class extends Component {
    public $isModalNotificationOpened = false;
}; ?>


<x-nav-link  wire:navigate>
    <button wire:click="$toggle('isModalNotificationOpened')">
        <i class="fas fa-bell"></i>
    <button >
</x-nav-link>
    