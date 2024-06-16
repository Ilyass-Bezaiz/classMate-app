<div class="flex flex-col gap-8 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    <x-form-section submit="addStudent">
        <x-slot name="title">
            {{ __('Ajouter un nouveau étudiant') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Un email sera envoyé au étudiant contenant son mot de passe.') }}
        </x-slot>

        <x-slot name="form">
            <div class="w-full flex items-start">
                <!-- Profile Photo -->
                <div x-data="{ photoName: null, photoPreview: null }" class="w-2/5 flex flex-col justify-start items-center gap-2">
                    <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                        x-on:change="
                photoName = $refs.photo.files[0].name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    photoPreview = e.target.result;
                };
                reader.readAsDataURL($refs.photo.files[0]);
                " />

                    <!-- Current Profile Photo -->
                    <div x-cloak x-show="! photoPreview">
                        <img src="/images/profile-holder.jpg" alt=""
                            class="block rounded-full h-28 w-28 bg-cover bg-no-repeat bg-center">
                    </div>

                    <!-- New Profile Photo Preview -->
                    <div x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full h-28 w-28 bg-cover bg-no-repeat bg-center"
                            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Ajouter Photo') }}
                    </x-secondary-button>

                    <x-input-error for="photo" class="mt-2" />
                </div>

                <div class="w-3/5 flex flex-col">
                    <!-- Name -->
                    <div class="h-24">
                        <x-label for="name" value="Nom complet" />
                        <x-input wire:model="name" type="text" name="name" placeholder="nom complet"
                            class="text-sm w-11/12 h-11 text-center" />
                        <x-input-error for="name" />
                    </div>

                    <!-- Email -->
                    <div class="h-24">
                        <x-label for="email" value="Email" />
                        <x-input type="email" wire:model="email" type="email" name="email"
                            placeholder="exemple@etu.uae.ac.ma" class="text-sm w-11/12 h-11 text-center" />
                        <x-input-error for="email" />
                    </div>

                    <!-- CIN -->
                    <div class="h-24">
                        <x-label for="CNE" value="CNE" />
                        <x-input wire:model="CNE" type="text" name="CNE" placeholder="CNE..MASSAR"
                            class="text-sm w-11/12 h-11 text-center" />
                        <x-input-error for="CNE" />
                    </div>

                    <!-- Classe -->
                    <div class="h-24">
                        <x-label for="classe">Affecter une
                            classe</x-label>
                        <x-select wire:model='classe' name="classe" class="text-sm w-11/12 h-11 text-center">
                            <x-slot name="options">
                                <option class="text-indigo-500" value="">Tout les classes</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </x-slot>
                        </x-select>
                        <x-input-error for="classe" />
                    </div>

                </div>
            </div>
        </x-slot>

        <x-slot name="actions">

            <x-button wire:loading.attr="disabled">
                {{ __('Enregistrer') }}
            </x-button>

        </x-slot>
    </x-form-section>
    <x-loading />

    <div class="flex items-center gap-10 rounded-[15px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Si vous souhaitez insérer plusieurs étudiants, vous pouvez essayer de les importer à partir d\'un fichier Excel.') }}
            </div>

            <div class="flex justify-end w-full">
                <a wire:navigate href="{{ route('upload-data') }}">
                    <x-secondary-button wire:loading.attr="disabled">
                        {{ __('Importer plusieurs étudiants') }}
                    </x-secondary-button>
                </a>
            </div>
        </div>
    </div>
</div>
