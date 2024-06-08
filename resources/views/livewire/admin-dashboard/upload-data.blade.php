<div x-data="{ confirmDataDeletion: @entangle('confirmDataDeletion') }" class="flex flex-col gap-4 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Import Professeurs --}}
    <x-form-section submit="importProfesseurs">
        <x-slot name="title">
            {{ __('Importer Professeurs') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Vous devez choisir un fichier excel contient un tableau de professeurs avec ces en-têtes:') }}

            <div class="w-full flex mt-2">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_complet
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                email
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                password
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                diplome
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                CIN
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

        </x-slot>

        <x-slot name="form">

            <!-- Professeur Excel file -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="professeurs-file" value="{{ __('Fichier Excel pour les Professeurs') }}" />
                <x-input id="professeurs-file" type="file" class="mt-1 block w-full" wire:model="professeursFile"
                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                <x-input-error for="professeursFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="professeursFile">
                    {{ __('Enregistrer') }}
                </x-button>
            </x-slot>
        </x-slot>
    </x-form-section>
    <x-section-border />

    {{-- Import Etudiants --}}
    <x-form-section submit="importEtudiants">
        <x-slot name="title">
            {{ __('Importer Etudiants') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Vous devez choisir un fichier excel contient un tableau de Etudiants avec ces en-tête:') }}

            <div class="w-full flex mt-2">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_complet
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                email
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                password
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                CNE
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>

        </x-slot>

        <x-slot name="form">

            <!-- Professeur Excel file -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="Etudiants-file" value="{{ __('Fichier Excel pour les Etudiants') }}" />
                <x-input id="Etudiants-file" type="file" class="mt-1 block w-full" wire:model="etudiantsFile" />
                <x-input-error for="etudiantsFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="etudiantsFile">
                    {{ __('Enregistrer') }}
                </x-button>
            </x-slot>
        </x-slot>
    </x-form-section>
    <x-section-border />

    {{-- Import Departements --}}
    <x-form-section submit="importDepartements">
        <x-slot name="title">
            {{ __('Importer Départements') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Vous devez choisir un fichier excel contient un tableau de Départements.') }}

            <div class="w-full flex mt-2">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_departement
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <x-label for="Departements-file" value="{{ __('Fichier Excel pour les Départements') }}" />
                <x-input id="Departements-file" type="file" class="mt-1 block w-full"
                    wire:model="departementsFile" />
                <x-input-error for="departementsFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="departementsFile">
                    {{ __('Enregistrer') }}
                </x-button>
            </x-slot>
        </x-slot>
    </x-form-section>
    <x-section-border />

    {{-- Import Filieres --}}
    <x-form-section submit="importFilieres">
        <x-slot name="title">
            {{ __('Importer Filières') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Vous devez choisir un fichier excel contient un tableau de Filières.') }}

            <div class="w-full flex mt-2">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_filiere
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_departement
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <x-label for="Filieres-file" value="{{ __('Fichier Excel pour les Filières') }}" />
                <x-input id="Filieres-file" type="file" class="mt-1 block w-full" wire:model="filieresFile" />
                <x-input-error for="filieresFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="filieresFile">
                    {{ __('Enregistrer') }}
                </x-button>
            </x-slot>
        </x-slot>
    </x-form-section>
    <x-section-border />

    {{-- Import Modules --}}
    <x-form-section submit="importModules">
        <x-slot name="title">
            {{ __('Importer Modules') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Vous devez choisir un fichier excel contient un tableau de Modules.') }}

            <div class="w-full flex mt-2">
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_module
                            </th>
                            <th scope="col" class="px-1 py-3 border-[1px] border-gray-800 dark:border-gray-400">
                                nom_filiere
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <x-label for="Modules-file" value="{{ __('Fichier Excel pour les Modules') }}" />
                <x-input id="Modules-file" type="file" class="mt-1 block w-full" wire:model="modulesFile" />
                <x-input-error for="modulesFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="modulesFile">
                    {{ __('Enregistrer') }}
                </x-button>
            </x-slot>
        </x-slot>
    </x-form-section>
    <x-section-border />

    @if (Auth::user()->role === app\Enums\Role::SUPERADMIN)
        {{-- Supprimer tout les données --}}
        <div class="flex items-center rounded-[15px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
            <div class="w-full flex items-center">
                <div class="text-sm text-gray-600 dark:text-gray-400 w-1/2">
                    {{ __('Supprimer tout les données (Tout les données dans la base de données seront supprimées définitivements)') }}
                </div>

                <div class="flex justify-end w-1/2">
                    <x-danger-button @click="confirmDataDeletion = true;" wire:loading.attr="disabled">
                        {{ __('Supprimer tout les données') }}
                    </x-danger-button>
                </div>
            </div>
            <!-- Delete All Data Confirmation Modal -->
            <x-dialog-modal wire:model.live="confirmDataDeletion">
                <x-slot name="title">
                    {{ __('Delete Account') }}
                </x-slot>

                <x-slot name="content">
                    <p>Vous aurez être diriger vers la page de login et vous pouvez vous connecter avec:</p>
                    <span>email: super.admin@gmail.com</span><br>
                    <span>mot de passe: 12345678</span>

                    <div class="mt-4">
                        <x-input type="password" class="mt-1 block w-3/4" autocomplete="current-password"
                            placeholder="{{ __('Password') }}" x-ref="superAdminPassword"
                            wire:model="superAdminPassword" wire:keydown.enter="deleteAllData" />
                        <x-input-error for="superAdminPassword" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button @click="confirmDataDeletion = false;" wire:loading.attr="disabled">
                        {{ __('Annuler') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3" wire:click="deleteAllData" wire:loading.attr="disabled">
                        {{ __('Supprimer') }}
                    </x-danger-button>
                </x-slot>
            </x-dialog-modal>
        </div>
    @endif

    <x-loading />
</div>
