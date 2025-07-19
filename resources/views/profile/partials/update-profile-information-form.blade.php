<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="grid sm:grid-cols-2 gap-2">
            {{-- Tipo de identificación --}}
            <div>
                <x-input-label for="identity_type_id" :value="__('Tipo identificación')" />
                <x-select id="identity_type_id" name="identity_type_id" class="block mt-1 w-full">
                    @foreach ($identityTypes as $identityType)
                        <option value="{{ $identityType->id }}"
                            {{ $identityType->id == old('identity_type_id', $person->identity_type_id) ? 'selected' : '' }}>
                            {{ $identityType->name }}
                        </option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('applicant.identity_type_id')" class="mt-2" />
            </div>
            {{-- Número de identificación --}}
            <div>
                <x-input-label for="identity_number" :value="__('Num. Identificación')" />
                <x-number-input id="identity_number" name="identity_number" type="text" class="mt-1 block w-full"
                    placeholder="Número de identificación" :value="old('identity_number', $person->identity_number)" required autofocus
                    autocomplete="identity_number" maxlength="12" />
                <x-input-error class="mt-2" :messages="$errors->get('identity_number')" />
            </div>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2">
            {{-- Nombre(s) --}}
            <div class="sm:col-span-2 md:col-span-1">
                <x-input-label for="name" :value="__('Nombre(s)')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                    placeholder="Nombre(s)" :value="old('name', $person->name)" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            {{-- Apellido paterno --}}
            <div>
                <x-input-label for="last_name" :value="__('Apellido paterno')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                    placeholder="Apellido paterno" :value="old('last_name', $person->last_name)" required autocomplete="last_name" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
            {{-- Apellido materno --}}
            <div>
                <x-input-label for="second_last_name" :value="__('Apellido materno')" />
                <x-text-input id="second_last_name" name="second_last_name" type="text" class="mt-1 block w-full"
                    placeholder="Apellido materno" :value="old('second_last_name', $person->second_last_name)" required autocomplete="second_last_name" />
                <x-input-error class="mt-2" :messages="$errors->get('second_last_name')" />
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-2">
            {{-- Celular --}}
            <div>
                <x-input-label for="phone" :value="__('Celular')" />
                <x-number-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                    placeholder="Número de Celular" :value="old('phone', $person->phone)" required autocomplete="phone" maxlength="9" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            {{-- Dirección --}}
            <div>
                <x-input-label for="address" :value="__('Dirección')" />
                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                    placeholder="Dirección" :value="old('address', $person->address)" required autocomplete="address" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
            {{-- Número de RUC --}}
            <div>
                <x-input-label for="ruc">RUC <span class="text-xs italic">(opcional)</span></x-input-label>
                <x-number-input id="ruc" name="ruc" type="text" class="block mt-1 w-full"
                    placeholder="Número de RUC" :value="old('ruc', $legalPerson?->ruc)" autocomplete="ruc" maxlength="11" />
                <x-input-error :messages="$errors->get('ruc')" class="mt-2" />
            </div>
            {{-- Razón Social --}}
            <div>
                <x-input-label for="company_name">Razón Social <span
                        class="text-xs italic">(opcional)</span></x-input-label>
                <x-text-input id="company_name" name="company_name" type="text" class="block mt-1 w-full"
                    placeholder="Razón Social" :value="old('company_name', $legalPerson?->company_name)" autocomplete="company_name" />
                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
            </div>
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
