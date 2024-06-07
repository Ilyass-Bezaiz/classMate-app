<div class="flex flex-col gap-4 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Import Professeurs --}}
    <x-form-section submit="importProfesseurs">
        <x-slot name="title">
            {{ __('Importer Professeurs') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Vous devez choisir un fichier excel contient un tableau de professeurs.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Professeur Excel file -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="professeurs-file" value="{{ __('professeurs excel file') }}" />
                <x-input id="professeurs-file" type="file" class="mt-1 block w-full" wire:model="professeursFile" required />
                <x-input-error for="professeursFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="importProfesseurs">
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
            {{ __('Vous devez choisir un fichier excel contient un tableau de Etudiants.') }}
        </x-slot>

        <x-slot name="form">

            <!-- Professeur Excel file -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="Etudiants-file" value="{{ __('Etudiants excel file') }}" />
                <x-input id="Etudiants-file" type="file" class="mt-1 block w-full" wire:model="etudiantsFile" required/>
                <x-input-error for="etudiantsFile" class="mt-2" />
            </div>


            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Enregitrés.') }}
                </x-action-message>

                <x-button wire:loading.attr="disabled" wire:target="importEtudiants">
                    {{ __('Enregistrer') }}
                </x-button>
            </x-slot>
        </x-slot>
    </x-form-section>
    <x-section-border />

    <x-loading />
</div>
