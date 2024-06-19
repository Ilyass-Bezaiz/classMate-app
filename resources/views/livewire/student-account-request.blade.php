<div class="bg-gray-100 w-screen h-screen flex flex-col gap-2 justify-start items-center pt-2">
    <x-authentication-card-logo />
    <div class="w-2/5">
        <div class="px-8 py-5 bg-white dark:bg-gray-800 shadow rounded-[30px]">
            <div class="w-full flex justify-center items-center">
                <div class="w-full flex flex-col">
                    <!-- Name -->
                    <div class="h-24">
                        <x-label for="name" value="Nom complet" />
                        <x-input wire:model="name" type="text" name="name" placeholder="nom complet"
                            class="text-center text-sm w-full h-11" />
                        <x-input-error for="name" />
                    </div>

                    <!-- Email -->
                    <div class="h-24">
                        <x-label for="email" value="Email" />
                        <x-input type="email" wire:model="email" type="email" name="email"
                            placeholder="exemple@pro.uae.ac.ma" class="text-center text-sm w-full h-11" />
                        <x-input-error for="email" />
                    </div>

                    <!-- CNE -->
                    <div class="h-24">
                        <x-label for="CNE" value="CNE" />
                        <x-input wire:model="CNE" type="text" name="CNE" placeholder="CNE"
                            class="text-center text-sm w-full h-11" />
                        <x-input-error for="CNE" />
                    </div>

                    <!-- Diplome -->
                    <div class="h-24">
                        <x-label for="diploma" value="Diplôme" />
                        <x-input wire:model="diploma" name="diploma" class="text-center text-sm w-full h-11"
                            placeholder="diplôme" />
                        <x-input-error for="diploma" />
                    </div>

                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Déjà inscrit ?') }}
                </a>

                <x-button wire:click="send" class="ms-4">
                    {{ __('Demander') }}
                </x-button>
            </div>
        </div>
    </div>
    <x-loading />
</div>
