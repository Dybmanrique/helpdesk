<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Desactivar cuenta</h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Una vez que su cuenta sea desactivada, no podrá acceder a ella ni a sus recursos o datos, hasta comunicarse
            con el administrador del sistema para su reactivación. Por favor, asegúrese de que desea proceder
            con la desactivación de su cuenta antes de continuar.
        </p>
    </header>
    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', { name: 'confirm-user-deactivation' })">
        Desactivar cuenta
    </x-danger-button>

    <x-modal name="confirm-user-deactivation" :show="$errors->userDeactivation->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.deactivate') }}" class="p-6">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">¿Está seguro que desea desactivar su cuenta?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Una vez que su cuenta sea desactivada, no podrá acceder a ella ni a sus recursos o datos, hasta
                comunicarse con el administrador del sistema para su reactivación. Por favor, asegúrese de que desea
                proceder con la desactivación de su cuenta antes de continuar.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" autocomplete="off" />

                <x-input-error :messages="$errors->userDeactivation->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                @can('Perfil de Usuario: Desactivar cuenta')
                    <x-danger-button class="ms-3">Desactivar cuenta</x-danger-button>
                @endcan
            </div>
        </form>
    </x-modal>
</section>
