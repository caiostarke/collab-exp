<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $skills = '';
    public string $password = '';
    public bool $isBusiness = false;
    public string $password_confirmation = '';

    public string $selectedOption = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // if ($selectedOption == 'developer') {
        //     $isBusiness = false; 
        // } else if ($selectedOption == 'business') {
        //     $isBusiness = true; 
        // } else {
        //     throw new Exception("Error Processing Request", 1);
        // }

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'skills' => ['required', 'string', 'lowercase', 'max:255'],
            'selectedOption' => ['required', 'in:developer,business'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['skills'] = explode(' ', $validated['skills']);

        $validated['isBusiness'] = ($validated['selectedOption'] == 'developer') ? false : true;
        
        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">

        <div class="form-group">
            <label for="userType"> Select User Type: </label>
            <select wire:model.live="selectedOption" class="form-control" id="userType">
                <option value="developer">Developer</option>
                <option value="business">Business</option>
            </select>
            <x-input-error :messages="$errors->get('selectedOption')" class="mt-2" />
        </div>
        
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Skills -->
        <div class="mt-4">
            <x-input-label for="skills" :value="__('Skills (Separate your skills using space [golang java php])')" />
            <x-text-input wire:model="skills" id="skills" class="block w-full mt-1" type="text" name="skills" required autocomplete="username" />
            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
        </div>
        
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full mt-1"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>   

</div>
