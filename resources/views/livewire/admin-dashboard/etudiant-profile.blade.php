<div x-data="{ editing: @entangle('editing'), deleting : @entangle('deleting') }" class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Profile details --}}
    <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <div class="flex flex-col h-full w-1/4 justify-start items-center gap-3 mt-4">

            {{-- Edit photo --}}
            <div x-data="{ photoName: null, photoPreview: null }" class="flex flex-col justify-start items-center gap-4">
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
                <div x-show="! photoPreview">
                    <img src="{{ $etudiant->user->profile_photo_url }}" alt="{{ $etudiant->user->name }}"
                        class="rounded-full h-24 w-24 object-cover shadow-md shadow-black">
                </div>

                <!-- New Profile Photo Preview -->
                <div x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full h-24 w-24 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button x-show="editing" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Changer Photo') }}
                </x-secondary-button>

                @if ($etudiant->user->profile_photo_path || session('message'))
                    <x-secondary-button x-show="editing" type="button" wire:click.prevent="deleteProfilePhoto">
                        {{ __('Supprimer Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>

            <h1 x-show="!editing" class="font-bold">
                {{ $etudiant->user->name }}
            </h1>
            <div x-show="!editing" class="rounded-[30px] bg-violet-100 dark:bg-gray-700 py-1 px-4">
                <h3 class="text-[#707FDD] text-sm text-center">
                    Etudiant
                </h3>
            </div>
            <x-input x-show="editing" wire:model="name" class="text-center text-sm rounded-[30px]" />
            <x-input-error for="name" />
        </div>
        <div class="flex items-center gap-4 flex-col flex-1">
            {{-- details --}}
            <div class="flex justify-center items-center gap-4">
                <div class="flex flex-col">
                    <x-label for="email" value="Email" />
                    <x-input name="email" wire:model="email" class="w-72 h-11 text-center text-sm rounded-[30px]"
                        x-bind:disabled="!editing" />

                    <x-input-error for="email" />
                </div>
                <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                <div>
                    <x-label for="phone" value="Téléphone" />
                    <x-input name="phone" wire:model="phone" class="w-72 h-11 text-center text-sm rounded-[30px]"
                        x-bind:disabled="!editing" />

                    <x-input-error for="phone" />
                </div>
            </div>
            <div class="flex justify-between gap-16">
                <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
            </div>
            <div class="flex justify-center items-center gap-4">
                <div>
                    <x-label for="CNE" value="CNE" />
                    <x-input name="CNE" wire:model="CNE" class="w-72 h-11 text-center text-sm rounded-[30px]"
                        x-bind:disabled="!editing" />

                    <x-input-error for="CNE" />
                </div>
                <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                <div>
                    <x-label for="classe">Classe</x-label>
                    <x-input x-show="!editing" name="classe" value="{{ $etudiant->classe->name }}"
                        class="w-72 h-11 text-center text-sm rounded-[30px]" disabled="true" />
                    <x-select x-show="editing" wire:model='classe' name="classe"
                        class="w-72 h-11 text-center text-sm rounded-[30px]">
                        <x-slot name="options">
                            {{-- <option value="{{ $classe->id }}">{{ $classe->name }}</option> --}}
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-error for="classe" />
                </div>
            </div>
            {{-- buttons --}}
            <div class="w-full flex text-center justify-end gap-2 mt-4">
                <x-danger-button x-show="!editing" @click="deleting = true">Supprimer étudiant</x-danger-button>
                <x-button x-show="!editing" @click="editing = true">Modifier</x-button>

                <x-secondary-button x-show="editing" wire:click="cancelEditing">Annuler</x-secondary-button>
                <x-button x-show="editing" wire:click="editStudent">Enregistrer</x-button>
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-4">
        <div class="flex gap-2 items-center ml-6">
            <h1 class="font-bold dark:text-gray-100">Examens de classe</h1>
            <div class="flex justify-center items-center bg-white dark:bg-gray-700 h-full px-4 rounded-[30px]">
                <p class="text-sm font-bold text-[#707FDD]">{{ $exams->count() }}</p>
            </div>
        </div>
        <div class="flex gap-4 w-full">
            {{-- Examen Card --}}
            <div class="min-w-1/3 flex flex-col gap-2">
                @if ($exams->count() > 0)
                    @foreach ($exams as $exam)
                        <div
                            class="flex flex-col w-96 h-48 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">
                            <h1 class="text-xl font-bold">{{ $exam->module->name }}</h1>
                            <h2><span class="text-gray-500">Classe:</span> {{ $exam->classe->name }}</h2>
                            <div class="h-full flex justify-end items-end">
                                <div class="bg-violet-100 cursor-pointer dark:bg-gray-700 rounded-[30px] py-2 px-6">
                                    <p class="text-sm"><span class="text-gray-500">le: </span>{{ $exam->date }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-col w-96 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">
                        <h1 class="text-xl font-bold">Aucun examen</h1>
                    </div>
                @endif
            </div>
            {{-- ? Absent Chart --}}
            <div class="w-2/3 h-96">
                <div class="h-full bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">
                    @livewire('admin-dashboard.student-absent-chart', ['user_id' => $etudiant->user->id])
                </div>
            </div>
        </div>
    </div>
    <x-dialog-modal wire:model.live="deleting">
        <x-slot name="title">
            {{ __('Supprimer l\'etudiant ') }}
        </x-slot>

        <x-slot name="content">
            {{ __('L\'étudiant sera définitivement supprimé') }}

            <div class="mt-4 flex flex-col gap-4" x-data="{}">
                <div class="flex flex-col gap-1">
                    <x-label for="password">Entrer votre mot de passe:</x-label>
                    <x-input-password class="mt-1 block w-3/4" wire:model="adminPassword" wire:keydown.enter="deleteStudent" />


                    <x-input-error for="adminPassword" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button @click="deleting = false" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-danger-button wire:click="deleteStudent" class="ml-2" wire:loading.attr="disabled">
                {{ __('Supprimer') }}
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
    <x-loading />
</div>
