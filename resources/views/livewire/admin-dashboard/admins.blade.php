<div x-data="{ addingAdmin: @entangle('addingAdmin'), deletingAdmin: @entangle('deletingAdmin'), deletingAdminId: @entangle('deletingAdminId'),  resetingAdmin: @entangle('resetingAdmin'), resetingAdminId: @entangle('resetingAdminId'), resetAdminEmail: @entangle('resetAdminEmail') }" class="flex flex-col gap-4 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Search Section --}}
    <div class="flex items-center gap-4">
        <div class="flex items-center relative">
            <svg class="absolute top-3 left-3" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.95349 16.5194C10.738 16.519 12.471 15.9217 13.8767 14.8224L18.2963 19.2418L19.7178 17.8203L15.2983 13.4009C16.3981 11.9952 16.9959 10.2618 16.9963 8.47698C16.9963 4.0426 13.3881 0.43457 8.95349 0.43457C4.51886 0.43457 0.910645 4.0426 0.910645 8.47698C0.910645 12.9114 4.51886 16.5194 8.95349 16.5194ZM8.95349 2.44517C12.2802 2.44517 14.9856 5.15044 14.9856 8.47698C14.9856 11.8035 12.2802 14.5088 8.95349 14.5088C5.62677 14.5088 2.92136 11.8035 2.92136 8.47698C2.92136 5.15044 5.62677 2.44517 8.95349 2.44517Z"
                    fill="#959595" />
            </svg>
            <input wire:model.live.debounce.300ms='search'
                class="h-[44px] w-[303px] px-10 outline-none rounded-[30px] border-none text-sm dark:bg-gray-800 dark:text-gray-100"
                type="serach" placeholder="Rechercher">
        </div>
        <div class="w-full flex justify-end">
            <button @click="addingAdmin = true;" wire:loading.attr="disabled"
                class="h-[44px] px-6 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                Ajouter un admin</button>
        </div>
    </div>
    <hr class="mb-4 w-200px border-none h-px bg-gray-200 dark:bg-gray-800" />
    <table class="w-full border-separate border-spacing-y-2 text-center text-sm dark:text-gray-100">
        <thead class="text-[#ACACAC] text-sm font-semibold">
            <tr>
                <th></th>
                <th>Nom</th>
                <th>CIN</th>
                <th>email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $admin)
                <tr x-data="{ editing: false, editingDepId: @entangle('editingDepId'), editingDepName: @entangle('editingDepName') }" class="h-20 bg-white dark:bg-gray-800">
                    <td class="rounded-l-[30px] w-24">
                        <img class="w-14 h-14 object-cover rounded-full shadow-md shadow-black ml-6"
                            src="{{ $admin->user->profilePicUrl() }}">
                    </td>
                    <td>
                        <span x-transition:enter>{{ $admin->user->name }}
                            @if (Auth::user()->id === $admin->user->id)
                                <span
                                    class="bg-indigo-500 bg-opacity-80 rounded-[15px] px-2.5 py-0.5 ml-1 text-gray-100">moi</span>
                            @endif
                        </span>
                    </td>
                    <td>
                        <span x-transition:enter>{{ $admin->CIN }}</span>
                    </td>
                    <td>
                        <span x-transition:enter>{{ $admin->user->email }}</span>
                    </td>
                    <td class="rounded-r-[30px]">
                        <div class="w-full flex justify-center gap-2">
                            @if (Auth::user()->id === $admin->user->id)
                                <a wire:navigate href="{{ route('profile.show') }}" title="mon profile"
                                    class="h-10 w-10 p-2 rounded-[15px] fill-white hover:fill-indigo-500 bg-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"
                                        preserveAspectRatio="xMaxYMax meet">
                                        <path
                                            d="M14.3365 12.3466L14.0765 11.9195C13.9082 12.022 13.8158 12.2137 13.8405 12.4092C13.8651 12.6046 14.0022 12.7674 14.1907 12.8249L14.3365 12.3466ZM9.6634 12.3466L9.80923 12.8249C9.99769 12.7674 10.1348 12.6046 10.1595 12.4092C10.1841 12.2137 10.0917 12.022 9.92339 11.9195L9.6634 12.3466ZM4.06161 19.002L3.56544 18.9402L4.06161 19.002ZM19.9383 19.002L20.4345 18.9402L19.9383 19.002ZM16 8.5C16 9.94799 15.2309 11.2168 14.0765 11.9195L14.5965 12.7737C16.0365 11.8971 17 10.3113 17 8.5H16ZM12 4.5C14.2091 4.5 16 6.29086 16 8.5H17C17 5.73858 14.7614 3.5 12 3.5V4.5ZM7.99996 8.5C7.99996 6.29086 9.79082 4.5 12 4.5V3.5C9.23854 3.5 6.99996 5.73858 6.99996 8.5H7.99996ZM9.92339 11.9195C8.76904 11.2168 7.99996 9.948 7.99996 8.5H6.99996C6.99996 10.3113 7.96342 11.8971 9.40342 12.7737L9.92339 11.9195ZM9.51758 11.8683C6.36083 12.8309 3.98356 15.5804 3.56544 18.9402L4.55778 19.0637C4.92638 16.1018 7.02381 13.6742 9.80923 12.8249L9.51758 11.8683ZM3.56544 18.9402C3.45493 19.8282 4.19055 20.5 4.99996 20.5V19.5C4.70481 19.5 4.53188 19.2719 4.55778 19.0637L3.56544 18.9402ZM4.99996 20.5H19V19.5H4.99996V20.5ZM19 20.5C19.8094 20.5 20.545 19.8282 20.4345 18.9402L19.4421 19.0637C19.468 19.2719 19.2951 19.5 19 19.5V20.5ZM20.4345 18.9402C20.0164 15.5804 17.6391 12.8309 14.4823 11.8683L14.1907 12.8249C16.9761 13.6742 19.0735 16.1018 19.4421 19.0637L20.4345 18.9402Z" />
                                    </svg>
                                </a>
                            @else
                                <div class="flex items-center gap-1">
                                    <button
                                    @click="resetingAdmin = true; resetingAdminId = '{{ $admin->id }}'; resetAdminEmail = '{{ $admin->user->email }}';"
                                        title="Reset admin password"
                                        class="h-10 w-10 p-2.5 rounded-[15px] bg-indigo-500 fill-white hover:fill-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                        <svg stroke="currentColor" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 125 125">
                                            <path
                                                d="M102.58,84.44a5.07,5.07,0,0,1,8.77,5.08,59.65,59.65,0,0,1-81.15,22,5.83,5.83,0,0,1-.69-.39,59.66,59.66,0,0,1-21.7-81,5.14,5.14,0,0,1,.46-.78A59.63,59.63,0,0,1,89.5,8a59.22,59.22,0,0,1,21.7,21.55l1-3.89a5.42,5.42,0,1,1,10.49,2.71L119,42.69a5.52,5.52,0,0,1-.48,1.23,5.43,5.43,0,0,1-6,3.28L98,44.52a5.42,5.42,0,0,1,2-10.66l2.33.43a49.56,49.56,0,0,0-85.31.37l-.14.26A49.55,49.55,0,0,0,34.9,102.57h0a49.54,49.54,0,0,0,67.66-18.14Zm-22-14.06h0l5.75,5.75h0l3.52,3.52L84.15,85.4l-3.52-3.52-5.57,5.57L69.31,81.7l5.57-5.57-3-3-6.41,6.42-5.75-5.75,6.42-6.42-2-2-2-2,0,0a16.95,16.95,0,0,1-23.92,0h0l-.28-.3a16.92,16.92,0,0,1,.28-23.63h0L44,33.64a16.93,16.93,0,0,1,24,23.93h0l0,0L80.63,70.38ZM61.31,40.23a7.67,7.67,0,0,0-10.77,0L44.73,46h0a7.68,7.68,0,0,0-.19,10.58l.2.19h0a7.68,7.68,0,0,0,10.77,0L61.31,51h0a7.68,7.68,0,0,0,0-10.77Z" />
                                        </svg>

                                    </button>
                                    <button
                                    @click="deletingAdmin = true; deletingAdminId = '{{ $admin->id }}';"
                                        wire:confirm="Are you sure you want to delete this department ?"
                                        class="h-10 w-10 p-3 rounded-[15px] bg-red-500 fill-white hover:fill-red-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-red-500 duration-200">
                                        <svg class="feather feather-edit" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path class="cls-1"
                                                d="M13,0H11A3,3,0,0,0,8,3V4H2A1,1,0,0,0,2,6H3V20a4,4,0,0,0,4,4H17a4,4,0,0,0,4-4V6h1a1,1,0,0,0,0-2H16V3A3,3,0,0,0,13,0ZM10,3a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V4H10Zm9,17a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6H19Z" />
                                            <path class="cls-1"
                                                d="M12,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,12,9Z" />
                                            <path class="cls-1" d="M15,18a1,1,0,0,0,2,0V10a1,1,0,0,0-2,0Z" />
                                            <path class="cls-1"
                                                d="M8,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,8,9Z" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <x-dialog-modal wire:model.live="addingAdmin">
        <x-slot name="title">
            {{ __('Ajouter un Administrateur') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Veuillez saisir tout les informations de l\'administrateur') }}

            <div class="mt-4 flex w-3/4 gap-2">
                <div class="flex flex-col gap-1 w-1/2" x-data="{}">
                    <x-input type="text" placeholder="{{ __('Nom complet') }}" x-ref="newAdminName"
                        wire:model="newAdminName" wire:keydown.enter="addAdmin" />

                    <x-input-error for="newAdminName" class="mt-2" />
                </div>
                <div class="flex flex-col gap-1 w-1/2" x-data="{}">
                    <x-input type="text" placeholder="{{ __('CIN') }}" x-ref="newAdminCIN"
                        wire:model="newAdminCIN" wire:keydown.enter="addAdmin" />

                    <x-input-error for="newAdminCIN" class="mt-2" />
                </div>
            </div>
            <div class="mt-4 flex flex-col gap-1 w-3/4" x-data="{}">
                <x-input type="text" placeholder="{{ __('email') }}" x-ref="newAdminEmail"
                    wire:model="newAdminEmail" wire:keydown.enter="addAdmin" />

                <x-input-error for="newAdminEmail" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button @click="addingAdmin = false;" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="addAdmin" class="ml-2" wire:loading.attr="disabled">
                {{ __('Ajouter') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="resetingAdmin">
        <x-slot name="title">
            {{ __('Réinitialisation du compte') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Le mot de passe sera aussi réintialisé et envoyer au admin par email') }}

            <div class="mt-4 flex flex-col gap-1 w-3/4" x-data="{}">
                <x-input type="text" placeholder="{{ __('email') }}" x-ref="resetAdminEmail"
                    wire:model="resetAdminEmail" wire:keydown.enter="resetAdminAccount" />

                <x-input-error for="resetAdminEmail" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button @click="resetingAdmin = false;" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button @click="resetingAdmin = false; $wire.resetAdminAccount()" class="ml-2" wire:loading.attr="disabled">
                {{ __('Réinitialiser') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="deletingAdmin">
        <x-slot name="title">
            {{ __('Supprimer un Administrateur') }}
        </x-slot>

        <x-slot name="content">
            {{ __('L\'administrateur sera définitivement supprimé') }}

            <div class="mt-4 flex flex-col gap-4" x-data="{}">
                <div class="flex flex-col gap-1">
                    <label for="password">Entrer votre mot de passe:</label>
                    <x-input-password class="mt-1 block w-3/4" wire:model="adminPassword" wire:keydown.enter="delete" />


                    <x-input-error for="adminPassword" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button @click="deletingAdmin = false; deletingAdminId = '';" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="delete" class="ml-2" wire:loading.attr="disabled">
                {{ __('Supprimer') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-loading />

</div>
