<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="grid sm:grid-cols-2 gap-2 mt-3">
            {{-- Tipo de Identificación --}}
            <div class="">
                <x-input-label for="identity_type_id" :value="__('Tipo Identificación')" />
                <x-select id="identity_type_id" class="block mt-1 w-full" name="identity_type_id" required>
                    @foreach ($identity_types as $identity)
                        <option value="{{ $identity->id }}"
                            {{ old('identity_type_id') == $identity->id ? 'selected' : '' }}>{{ $identity->name }}
                        </option>
                    @endforeach
                </x-select>
            </div>
            {{-- Número de identificación --}}
            <div class="">
                <x-input-label for="identity_number" :value="__('Núm. Identificación')" />
                <x-number-input id="identity_number" class="block mt-1 w-full" type="text" name="identity_number"
                    :value="old('identity_number')" autocomplete="identity_number" maxlength="12" required />
                <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
            </div>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2 mt-3">
            {{-- Nombre(s) --}}
            <div class="sm:col-span-2 md:col-span-1">
                <x-input-label for="name" :value="__('Nombre(s)')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    autocomplete="name" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            {{-- Apellido Paterno --}}
            <div>
                <x-input-label for="last_name" :value="__('Apellido Paterno')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
                    autocomplete="last_name" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
            {{-- Apellido Materno --}}
            <div>
                <x-input-label for="second_last_name" :value="__('Apellido Materno')" />
                <x-text-input id="second_last_name" class="block mt-1 w-full" type="text" name="second_last_name"
                    :value="old('second_last_name')" autocomplete="second_last_name" required />
                <x-input-error :messages="$errors->get('second_last_name')" class="mt-2" />
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-2 mt-3">
            {{-- Celular --}}
            <div class="">
                <x-input-label for="phone" :value="__('Celular')" />
                <x-number-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                    :value="old('phone')" autocomplete="phone" maxlength="9" required />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            {{-- Dirección --}}
            <div class="">
                <x-input-label for="address" :value="__('Dirección')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                    autocomplete="address" required />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
        </div>

        {{-- Número de RUC --}}
        <div class="mt-3">
            <x-input-label for="ruc">RUC <span class="text-xs italic">(opcional)</span></x-input-label>
            <x-number-input id="ruc" class="block mt-1 w-full" type="text" name="ruc" :value="old('ruc')"
                autocomplete="ruc" maxlength="11" />
            <x-input-error :messages="$errors->get('ruc')" class="mt-2" />
        </div>
        {{-- Razón Social --}}
        <div class="mt-3">
            <x-input-label for="company_name">Razón Social <span class="text-xs italic">(opcional)</span></x-input-label>
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name"
                :value="old('company_name')" autocomplete="company_name" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        {{-- Email Address --}}
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                autocomplete="username" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                autocomplete="new-password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" autocomplete="new-password" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-3">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
