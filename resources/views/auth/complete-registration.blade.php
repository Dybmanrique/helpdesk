<x-guest-layout>

    <h1 class="font-medium text-2xl text-gray-800 dark:text-gray-200">Termina tu registro</h1>
    <p class="flex gap-2 text-sm text-gray-600 dark:text-gray-400">Completa el siguiente formulario para crear una
        cuenta.</p>

    <form id="completeRegistrationForm" method="POST" action="{{ route('store_complete_registration') }}">
        @csrf
        <div class="grid sm:grid-cols-2 gap-2 mt-6">
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
                <div id="identity_number-error-container"></div>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2 mt-3">
            {{-- Nombre(s) --}}
            <div class="sm:col-span-2 md:col-span-1">
                <x-input-label for="name" :value="__('Nombre(s)')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $name)"
                    autocomplete="off" required />
                <div id="name-error-container"></div>
            </div>
            {{-- Apellido Paterno --}}
            <div>
                <x-input-label for="last_name" :value="__('Apellido Paterno')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $last_name)"
                    autocomplete="off" required />
                <div id="last_name-error-container"></div>
            </div>
            {{-- Apellido Materno --}}
            <div>
                <x-input-label for="second_last_name" :value="__('Apellido Materno')" />
                <x-text-input id="second_last_name" class="block mt-1 w-full" type="text" name="second_last_name"
                    :value="old('second_last_name', $second_last_name)" autocomplete="off" required />
                <div id="second_last_name-error-container"></div>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-2 mt-3">
            {{-- Celular --}}
            <div class="">
                <x-input-label for="phone" :value="__('Celular')" />
                <x-number-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                    :value="old('phone')" autocomplete="phone" maxlength="9" required />
                <div id="phone-error-container"></div>
            </div>
            {{-- Dirección --}}
            <div class="">
                <x-input-label for="address" :value="__('Dirección')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"
                    autocomplete="address" required />
                <div id="address-error-container"></div>
            </div>
        </div>

        {{-- Número de RUC --}}
        <div class="mt-3">
            <x-input-label for="ruc">RUC <span class="text-xs italic">(opcional)</span></x-input-label>
            <x-number-input id="ruc" class="block mt-1 w-full" type="text" name="ruc" :value="old('ruc')"
                autocomplete="ruc" maxlength="11" />
            <div id="ruc-error-container"></div>
        </div>
        {{-- Razón Social --}}
        <div class="mt-3">
            <x-input-label for="company_name">Razón Social <span
                    class="text-xs italic">(opcional)</span></x-input-label>
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name"
                :value="old('company_name')" autocomplete="company_name" />
            <div id="company_name-error-container"></div>
        </div>

        {{-- Email Address --}}
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $email)"
                autocomplete="username" required />
            <div id="email-error-container"></div>
        </div>

        {{-- Password --}}
        <div class="mt-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="off"
                required />
            <div id="password-error-container"></div>
        </div>

        {{-- Confirm Password --}}
        <div class="mt-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" autocomplete="off" required />
            <div id="password_confirmation-error-container"></div>
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
    @section('js')
        <script type="module" src="{{ asset('js/auth/complete-registration.js') }}?v={{ env('APP_VERSION') }}"></script>
    @endsection
</x-guest-layout>
