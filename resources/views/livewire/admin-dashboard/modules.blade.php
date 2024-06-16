<div x-data="{ addingModule: @entangle('addingModule') }" class="flex flex-col gap-4 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Search Section --}}
    <div class="flex items-center gap-4">
        <div class="flex items-center relative">
            <svg class="absolute top-3 left-3" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.95349 16.5194C10.738 16.519 12.471 15.9217 13.8767 14.8224L18.2963 19.2418L19.7178 17.8203L15.2983 13.4009C16.3981 11.9952 16.9959 10.2618 16.9963 8.47698C16.9963 4.0426 13.3881 0.43457 8.95349 0.43457C4.51886 0.43457 0.910645 4.0426 0.910645 8.47698C0.910645 12.9114 4.51886 16.5194 8.95349 16.5194ZM8.95349 2.44517C12.2802 2.44517 14.9856 5.15044 14.9856 8.47698C14.9856 11.8035 12.2802 14.5088 8.95349 14.5088C5.62677 14.5088 2.92136 11.8035 2.92136 8.47698C2.92136 5.15044 5.62677 2.44517 8.95349 2.44517Z"
                    fill="#959595" />
            </svg>
            <input wire:model.live='search'
                class="h-[44px] w-[303px] px-10 outline-none rounded-[30px] border-none text-sm dark:bg-gray-800 dark:text-gray-100"
                type="serach" placeholder="Rechercher">
        </div>
        <div class="flex items-center gap-1">
            <select wire:model.live.debounce='filter_fil'
                class="h-[34px] rounded-[30px] outline-none border-none text-sm pl-4 dark:bg-gray-800 dark:text-gray-100"
                name="filiere">
                <option class="text-[#707FDD]" value="">Tout les filières</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full flex justify-end">
            <x-button @click="addingModule = true;" class="h-[44px] rounded-[30px]">
                Ajouter un module
            </x-button>
        </div>
    </div>
    <hr class="mb-4 w-200px border-none h-px bg-gray-200 dark:bg-gray-800" />
    <table class="w-full border-separate border-spacing-y-2 text-center text-sm dark:text-gray-100">
        <thead class="text-[#ACACAC] text-sm font-semibold">
            <tr>
                <th class="w-1/3">Nom Module</th>
                <th class="w-1/3">Filière</th>
                <th class="w-[15%]">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $module)
                <tr x-data="{ deleting: @entangle('deletingMod'), deletingModId: @entangle('deletingModId'), editingModId: @entangle('editingModId'), editingModName: @entangle('editingModName'), editingModFiliere: @entangle('editingModFiliere') }" class="h-20 bg-white dark:bg-gray-800">
                    <td class="rounded-l-[30px] w-2/5">
                        <template x-if="editingModId === '{{ $module->id }}'">
                            <div>
                                <input x-transition:enter x-model="editingModName" type="text"
                                    class="bg-gray-100 dark:bg-gray-900 text-center text-gray-900 dark:text-gray-100 rounded-[15px] mx-auto text-sm block w-44 p-2.5">
                                <x-input-error class="text-sm" for="editingModName" class="mt-2" />
                            </div>
                        </template>
                        <template x-if="editingModId !== '{{ $module->id }}'">
                            <span x-transition:enter>{{ $module->name }}</span>
                        </template>
                    </td>
                    <td>
                        <template x-if="editingModId === '{{ $module->id }}'">
                            <select wire:model="editingModFiliere"
                                class="h-[34px] w-32 rounded-[15px] outline-none border-none text-sm pl-4 bg-gray-100 dark:bg-gray-900 dark:text-gray-100">
                                @foreach ($filieres as $filiere)
                                    <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="text-sm" for="editingModFiliere" class="mt-2" />
                        </template>
                        <template x-if="editingModId !== '{{ $module->id }}'">
                            <span x-transition:enter>{{ $module->major->name ?? 'Aucun' }}</span>
                        </template>
                    </td>
                    <td class="rounded-r-[30px]">
                        <div class="w-full flex justify-center gap-2">
                            <template x-if="editingModId === '{{ $module->id }}'">
                                <div>
                                    <button @click="$wire.updateModule();"
                                        class="h-10 w-10 p-3 rounded-[15px] fill-white hover:fill-indigo-500 bg-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                            <path
                                                d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button @click="editingModId = '';"
                                        class="h-10 w-10 p-3 rounded-[15px] bg-red-500 fill-white hover:fill-red-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-red-500 duration-200">
                                        <svg viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.587 16.001l6.096 6.096c0.396 0.396 0.396 1.039 0 1.435l-2.151 2.151c-0.396 0.396-1.038 0.396-1.435 0l-6.097-6.096-6.097 6.096c-0.396 0.396-1.038 0.396-1.434 0l-2.152-2.151c-0.396-0.396-0.396-1.038 0-1.435l6.097-6.096-6.097-6.097c-0.396-0.396-0.396-1.039 0-1.435l2.153-2.151c0.396-0.396 1.038-0.396 1.434 0l6.096 6.097 6.097-6.097c0.396-0.396 1.038-0.396 1.435 0l2.151 2.152c0.396 0.396 0.396 1.038 0 1.435l-6.096 6.096z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            <template x-if="editingModId !== '{{ $module->id }}'">
                                <div>
                                    <button
                                        @click="editingModId = '{{ $module->id }}'; editingModName = '{{ $module->name }}'; editingModFiliere = '{{ $module->major->id }}';"
                                        class="h-10 w-10 p-3 rounded-[15px] bg-indigo-500 text-white hover:text-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                        <svg class="feather feather-edit fill-none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </button>
                                    <button @click="deleting = true; deletingModId = '{{ $module->id }}';"
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
                            </template>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <x-dialog-modal wire:model.live="addingModule">
        <x-slot name="title">
            {{ __('Ajouter un Module') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Veuillez entrer les infos complet du Module') }}

            <div class="flex flex-col gap-1 mt-4">
                <x-label for="filiere">Nom du module:</x-label>
                <x-input type="text" class="mt-1 block w-3/4" placeholder="{{ __('Module') }}" x-ref="newModName"
                    wire:model="newModName" wire:keydown.enter="addModule" />

                <x-input-error for="newModName" class="mt-2" />
            </div>

            <div class="flex flex-col gap-1 mt-4">
                <x-label for="filiere">Filière du module:</x-label>
                <x-select name="filiere" wire:model="newModFiliere"
                    class="w-3/4">
                    <x-slot name="options">
                        <option value="">Selectionner Filière</option>
                        @foreach ($filieres as $filiere)
                            <option value="{{ $filiere->id }}">{{ $filiere->name }}</option>
                        @endforeach
                    </x-slot>
                </x-select>
                <x-input-error for="newModFiliere" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('addingModule')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="addModule" class="ml-2" wire:loading.attr="disabled" wire:target="newModName">
                {{ __('Ajouter') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="deletingMod">
        <x-slot name="title">
            {{ __('Supprimer module') }}
        </x-slot>

        <x-slot name="content">
            {{ __('La module sera définitivement supprimée') }}

            <div class="mt-4 flex flex-col gap-4" x-data="{}">
                <div class="flex flex-col gap-1">
                    <label for="password">Entrer votre mot de passe:</label>
                    <x-input-password class="mt-1 block w-3/4" wire:model="adminPassword"
                        wire:keydown.enter="delete" />


                    <x-input-error for="adminPassword" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deletingMod')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="delete" class="ml-2" wire:loading.attr="disabled">
                {{ __('Supprimer') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-loading />
</div>
