<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            
            <img src="http://{{$_SERVER['HTTP_HOST']}}/img/landingpage/hero-img.png" class="" width="250px">
            {{-- <a href="/"> --}}
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            {{-- </a> --}}
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Asal Instansi -->
            <div>
                <x-label for="asal_instansi" :value="__('Asal Instansi')" />

                <x-input id="asal_instansi" class="block mt-1 w-full" type="text" name="asal_instansi" :value="old('asal_instansi')" required autofocus />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="nama" :value="__('Nama')" />

                <x-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="telp" :value="__('No Telephone')" />

                <x-input id="telp" class="block mt-1 w-full" type="number" name="telp" :value="old('telp')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>