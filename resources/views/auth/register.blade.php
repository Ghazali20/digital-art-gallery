<x-guest-layout>
    {{-- Pastikan body di guest.blade.php menggunakan class="bg-monochrome-elegant" --}}

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            {{-- LINK SUDAH PUNYA AKUN (LOGIN) --}}
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none transition duration-150 mr-4" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            {{-- TOMBOL REGISTER (Styling Monokrom) --}}
            <x-primary-button class="ms-4 bg-black hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded text-sm transition duration-150">
                {{ __('REGISTER') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>