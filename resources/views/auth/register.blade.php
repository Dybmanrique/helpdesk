<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div x-data="{ user_type: @js(old('user_type', 'natural')) }">
            {{-- Registrarse como persona natural o persona jurídica --}}
            <x-input-label for="user_type" :value="__('Regístrese como')" />
            <div class="grid sm:grid-cols-2 gap-2 mt-1">
                <div class="flex items-center justify-center">
                    <input x-model="user_type" id="user_type_person" name="user_type" type="radio" value="natural"
                        class="peer sr-only" {{ old('user_type', 'natural') === 'natural' ? 'autofocus' : '' }} />
                    <label for="user_type_person"
                        class="w-full h-full flex items-center justify-center gap-2 font-medium text-sm text-gray-700 dark:text-gray-300 rounded-xl p-2 border border-gray-300 dark:border-gray-700 peer-checked:text-gray-200 peer-focus:ring-2 peer-checked:bg-gray-800 dark:peer-checked:bg-gray-200 cursor-pointer transition-colors duration-200">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                        <span>Persona Natural</span>
                    </label>
                </div>
                <div class="flex items-center justify-center">
                    <input x-model="user_type" id="user_type_company" name="user_type" type="radio" value="juridica"
                        class="peer sr-only" {{ old('user_type', 'natural') === 'juridica' ? 'autofocus' : '' }} />
                    <label for="user_type_company"
                        class="w-full h-full flex items-center justify-center gap-2 font-medium text-sm text-gray-700 dark:text-gray-300 rounded-xl p-2 border border-gray-300 dark:border-gray-700 peer-checked:text-gray-200 peer-focus:ring-2 peer-checked:bg-gray-800 dark:peer-checked:bg-gray-200 cursor-pointer transition-colors duration-200">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="">
                                <rect width="16" height="20" x="4" y="2" rx="2" ry="2" />
                                <path d="M9 22v-4h6v4" />
                                <path d="M8 6h.01" />
                                <path d="M16 6h.01" />
                                <path d="M12 6h.01" />
                                <path d="M12 10h.01" />
                                <path d="M12 14h.01" />
                                <path d="M16 10h.01" />
                                <path d="M16 14h.01" />
                                <path d="M8 10h.01" />
                                <path d="M8 14h.01" />
                            </svg>
                        </span>
                        <span>Persona Jurídica</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('user_type')" class="col-span-1 sm:col-span-2" />
            </div>

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
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" autocomplete="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                {{-- Apellido Paterno --}}
                <div>
                    <x-input-label for="last_name" :value="__('Apellido Paterno')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                        :value="old('last_name')" autocomplete="last_name" required />
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
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                        :value="old('address')" autocomplete="address" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>

            <template x-if="user_type === 'juridica'">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 10)" x-show="show" x-transition>
                    {{-- Número de RUC --}}
                    <div class="mt-3">
                        <x-input-label for="ruc" :value="__('RUC')" />
                        <x-number-input id="ruc" class="block mt-1 w-full" type="text" name="ruc"
                            :value="old('ruc')" autocomplete="ruc" maxlength="11" required />
                        <x-input-error :messages="$errors->get('ruc')" class="mt-2" />
                    </div>
                    {{-- Razón Social --}}
                    <div class="mt-3">
                        <x-input-label for="company_name" :value="__('Razón Social')" />
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name"
                            :value="old('company_name')" autocomplete="company_name" required />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>
                </div>
            </template>
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
