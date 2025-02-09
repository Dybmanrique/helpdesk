<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="md:flex">
            {{-- Nombre --}}
            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            
            {{-- Apellido Paterno --}}
            <div>
                <x-input-label for="last_name" :value="__('Apellido Paterno')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
    
            {{-- Apellido Materno --}}
            <div>
                <x-input-label for="second_last_name" :value="__('Apellido Materno')" />
                <x-text-input id="second_last_name" class="block mt-1 w-full" type="text" name="second_last_name" :value="old('second_last_name')" required autocomplete="second_last_name" />
                <x-input-error :messages="$errors->get('second_last_name')" class="mt-2" />
            </div>
        </div>
          
        <div class="grid lg:grid-cols-2">
            {{-- Celular --}}
            <div class="mt-3">
                <x-input-label for="phone" :value="__('Celular')" />
                <x-number-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required autocomplete="phone" maxlength="9"/>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
    
            {{-- Número de identificación --}}
            <div class="mt-3">
                <x-input-label for="identity_number" :value="__('Núm. Identificación')" />
                <x-number-input id="identity_number" class="block mt-1 w-full" type="text" name="identity_number" :value="old('identity_number')" required autocomplete="identity_number" />
                <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
            </div>
        </div>

        {{-- Dirección --}}
        <div class="mt-3">
            <x-input-label for="address" :value="__('Dirección')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>
        
        {{-- Email Address --}}
        <div class="mt-3">
            <div class="flex">
                <x-input-label for="email" :value="__('Email')" />
                <span class="text-red-600">&nbsp;*</span>
            </div>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ identity_type_id: @js(old('identity_type_id','')) }" class="mt-3">
            {{-- Tipo de Identificación --}}
            <x-input-label for="identity_type_id" :value="__('Tipo Identificación')" />
            <x-select x-model="identity_type_id" id="identity_type_id" class="block mt-1 w-full" name="identity_type_id" :value="old('identity_type_id')" required>
                @foreach ($identity_types as $identity)
                    <option value="{{$identity->id}}">{{$identity->name}}</option>
                @endforeach
            </x-select>
            <template x-if="identity_type_id == 2 || identity_type_id === 'Persona Jurídica'">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 10)" x-show="show" x-transition>
                    {{-- Número de RUC --}}
                    <div class="mt-3">
                        <div class="flex">
                            <x-input-label for="ruc" :value="__('RUC')" />
                            <span class="text-red-600">&nbsp;*</span>
                        </div>
                        <x-number-input id="ruc" class="block mt-1 w-full" type="text" name="ruc" :value="old('ruc')" required autocomplete="ruc" maxlength="11"/>
                        <x-input-error :messages="$errors->get('ruc')" class="mt-2" />
                    </div>
                    {{-- Razón Social --}}
                    <div class="mt-3">
                        <div class="flex">
                            <x-input-label for="company_name" :value="__('Razón Social')" />
                            <span class="text-red-600">&nbsp;*</span>
                        </div>
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autocomplete="company_name" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>
                </div>
            </template>
        </div>

        {{-- Password --}}
        <div class="mt-3">
            <div class="flex">
                <x-input-label for="password" :value="__('Password')" />
                <span class="text-red-600">&nbsp;*</span>
            </div>
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div class="mt-3">
            <div class="flex">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <span class="text-red-600">&nbsp;*</span>
            </div>
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-3">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
