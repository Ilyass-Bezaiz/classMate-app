<div class="pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- ? Main vertical div contain 3 sections --}}
    <div class="flex flex-col gap-7">
        {{-- ? 1st horixental dev contain 2 div => chart and infos --}}
        <div class="flex gap-4 items-center">
            <div x-data="{ showEdit: @entangle('showEdit') }" class="w-3/5 rounded-[30px] p-8 bg-white dark:bg-gray-800 dark:text-gray-100">
                <div class="text-xl font-semibold mb-3">Classe Infos</div>

                <div x-show="!showEdit" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="flex items-center gap-4 flex-col flex-1">
                    {{-- details --}}
                    <div wire:poll class="flex justify-center items-center gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="name">Classe</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-52 h-11 rounded-[30px]">
                                <p class="text-gray-800 dark:text-gray-200 text-sm">
                                    {{ $class->name }}
                                </p>
                            </div>
                        </div>
                        <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="school_year">Année
                                scolaire</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-52 h-11 rounded-[30px] text-center align-middle">
                                <p class="text-gray-800 dark:text-gray-200 text-sm">
                                    {{ $class->school_year }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between gap-16">
                        <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                        <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    </div>
                    <div class="flex justify-center items-center gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="major">Filière</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-52 h-11 rounded-[30px]">
                                <p class="text-gray-800 dark:text-gray-200 text-sm">
                                    {{ $class->major->name }}</p>
                            </div>
                        </div>
                        <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="students_number">Nombre
                                d'etudiants</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-52 h-11 rounded-[30px] text-center align-middle">
                                <p class="text-[#707FDD] cursor-pointer font-semibold text-sm">
                                    {{ $class->students->count() }} </p>
                            </div>
                        </div>
                    </div>
                    {{-- buttons --}}
                    <div class="w-full flex justify-end gap-2 mt-4">
                        <button wire:click="$toggle('deletingClass')"
                            class="h-11 w-48 bg-red-500 rounded-[30px] text-white border border-transparent hover:border-red-500 hover:bg-transparent hover:text-red-500 text-sm font-semibold duration-200">
                            Supprimer classe</button>
                        <button @click="showEdit = true;"
                            class="h-11 w-48 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                            Modifier</button>
                    </div>
                </div>
                <div x-show="showEdit" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="flex items-center gap-4 flex-col flex-1">
                    {{-- details --}}
                    <div class="flex justify-center items-center gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="name">Classe</label>
                            <input wire:model="name" name="name" type="text"
                                class="bg-gray-100 dark:bg-gray-900 text-center text-gray-900 dark:text-gray-100 rounded-[30px] mx-auto text-sm block w-52 h-11 p-2.5">

                            <x-input-error for="name" class="mt-2" />
                        </div>
                        <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                        <div>
                            {{-- TODO add phone in db --}}
                            <label for="schoolYear" class="font-semibold text-sm text-gray-400 ml-4">Année
                                scolaire:</label>
                            <select name="schoolYear" wire:model.blur="schoolYear" wire:keydown.enter="update"
                                class="bg-gray-100 text-center dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-[30px] mx-auto text-sm block w-52 h-11 p-2.5">
                                @for ($year = date('Y'); $year <= date('Y') + 10; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>

                            <x-input-error for="schoolYear" class="mt-2" />
                        </div>
                    </div>
                    <div class="flex justify-between gap-16">
                        <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                        <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    </div>
                    <div class="flex justify-center items-center gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="major">Filière</label>
                            <select wire:model="classFil"
                                class="bg-gray-100 text-center dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-[30px] mx-auto text-sm block w-52 h-11 p-2.5">
                                @foreach ($filieres as $fil)
                                    <option value="{{ $fil->id }}">{{ $fil->name }}</option>
                                @endforeach
                            </select>

                            <x-input-error for="classFil" class="mt-2" />
                        </div>
                        <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                        <div>
                            {{-- TODO add diplome in db --}}
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="students_number">Nombre
                                d'etudiants</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-52 h-11 rounded-[30px] text-center align-middle">
                                <p class="text-[#707FDD] cursor-pointer font-semibold text-sm">
                                    {{ $class->students->count() }} </p>
                            </div>
                        </div>
                    </div>

                    {{-- buttons --}}
                    <div class="w-full flex justify-end gap-2 mt-4">
                        <button @click="showEdit = false;"
                            class="h-11 w-48 bg-red-500 rounded-[30px] text-white border border-transparent hover:border-red-500 hover:bg-transparent hover:text-red-500 text-sm font-semibold duration-200">
                            Annuler</button>
                        <button wire:click="update"
                            class="h-11 w-48 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                            Enregistrer</button>
                    </div>
                </div>

            </div>
            {{-- ? CHART --}}
            <div class="w-2/5 h-[348px] rounded-[30px] p-8 bg-white dark:bg-gray-800 dark:text-gray-100">
                <div class="text-xl font-semibold mb-3">Classe Absences</div>
                <livewire:admin-dashboard.class-absent-chart :classId="$class->id" />
            </div>
        </div>
        {{-- ? 2nd dev --}}
        {{-- <div class="flex gap-4 items-center">
      <div>test</div>
    </div> --}}
        {{-- ? 3rd dev class members --}}
        <div class="flex flex-col gap-5">
            <div class="flex gap-4 items-center px-2 py-3 border-b border-[#c1c1c1]">
                <div class="text-xl font-semibold dark:text-white">Professeurs</div>
                <div class="bg-white text-[#707FDD] dark:bg-gray-800  rounded-full px-2 py-1">
                    {{ $class->teachers->count() }}
                </div>
                <div class="w-full flex justify-end items-center">
                    <button wire:click="$toggle('addingTeacher')"
                        class="h-11 w-48 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                        Affecter professeur</button>
                </div>
            </div>
            <div>
                {{-- ? class teachers table --}}
                <table class="w-full border-separate border-spacing-y-2 text-center text-sm dark:text-gray-100">
                    <thead class="text-[#ACACAC] text-sm font-semibold">
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>CIN</th>
                            <th>module affectée</th>
                            <th>Absences</th>
                            <th class="w-2/12">actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($professeurs as $professeur)
                            <tr x-data="{ editing: false, deleting: @entangle('deletingTeacher'), deletingTeacherId: @entangle('deletingTeacherId'), editingTeacherId: @entangle('editingTeacherId'), editingTeacherModule: @entangle('editingTeacherModule') }" wire:key={{ $professeur->id }}
                                class="h-20 bg-white dark:bg-gray-800">
                                <td class="rounded-l-[30px] w-24">
                                    <img class=" h-12 w-12 rounded-full shadow-md shadow-black ml-6"
                                        src="{{ $professeur->user->profilePicUrl() }}"
                                        alt="{{ $professeur->user->name }}">

                                </td>
                                <td class="text-indigo-500 font-semibold">
                                    <a wire:navigate href="{{ route('professeur.profile', $professeur->user->id) }}">
                                        {{ $professeur->user->name }}
                                    </a>
                                </td>
                                <td class="">{{ $professeur->CIN }}</td>
                                <td class="">
                                    <template x-if="editing">
                                        <select x-model="editingTeacherModule"
                                            class="h-[34px] w-32 rounded-[15px] outline-none border-none text-sm pl-4 bg-gray-100 dark:bg-gray-900 dark:text-gray-100">
                                            @foreach ($class->major->modules as $module)
                                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                    </template>
                                    <template x-if="!editing">
                                        <span x-transition:enter>{{ $professeur->module->name }}</span>
                                    </template>
                                </td>
                                <td class="">{{ $professeur->absent_sessions }}</td>
                                <td class="rounded-r-[30px]">
                                    <div class="w-full flex justify-center gap-2">
                                        <template x-if="editing">
                                            <div>
                                                <button @click="editing = false; $wire.updateTeacherModule();"
                                                    class="h-10 w-10 p-3 rounded-[15px] fill-white hover:fill-indigo-500 bg-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                                        <path
                                                            d="M 26.980469 5.9902344 A 1.0001 1.0001 0 0 0 26.292969 6.2929688 L 11 21.585938 L 4.7070312 15.292969 A 1.0001 1.0001 0 1 0 3.2929688 16.707031 L 10.292969 23.707031 A 1.0001 1.0001 0 0 0 11.707031 23.707031 L 27.707031 7.7070312 A 1.0001 1.0001 0 0 0 26.980469 5.9902344 z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button @click="editing = false"
                                                    class="h-10 w-10 p-3 rounded-[15px] bg-red-500 fill-white hover:fill-red-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-red-500 duration-200">
                                                    <svg viewBox="0 0 32 32" version="1.1"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M19.587 16.001l6.096 6.096c0.396 0.396 0.396 1.039 0 1.435l-2.151 2.151c-0.396 0.396-1.038 0.396-1.435 0l-6.097-6.096-6.097 6.096c-0.396 0.396-1.038 0.396-1.434 0l-2.152-2.151c-0.396-0.396-0.396-1.038 0-1.435l6.097-6.096-6.097-6.097c-0.396-0.396-0.396-1.039 0-1.435l2.153-2.151c0.396-0.396 1.038-0.396 1.434 0l6.096 6.097 6.097-6.097c0.396-0.396 1.038-0.396 1.435 0l2.151 2.152c0.396 0.396 0.396 1.038 0 1.435l-6.096 6.096z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="!editing">
                                            <div>
                                                <button
                                                    @click="editing = true; editingTeacherId = '{{ $professeur->id }}'; editingTeacherModule = '{{ $professeur->module->id }}'"
                                                    class="h-10 w-10 p-3 rounded-[15px] bg-indigo-500 text-white hover:text-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                                    <svg class="feather feather-edit fill-none" stroke="currentColor"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                        <path
                                                            d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    @click="deleting = true; deletingTeacherId = '{{ $professeur->id }}';"
                                                    wire:confirm="Are you sure you want to delete this department ?"
                                                    class="h-10 w-10 p-3 rounded-[15px] bg-red-500 fill-white hover:fill-red-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-red-500 duration-200">
                                                    <svg class="feather feather-edit" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path class="cls-1"
                                                            d="M13,0H11A3,3,0,0,0,8,3V4H2A1,1,0,0,0,2,6H3V20a4,4,0,0,0,4,4H17a4,4,0,0,0,4-4V6h1a1,1,0,0,0,0-2H16V3A3,3,0,0,0,13,0ZM10,3a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V4H10Zm9,17a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6H19Z" />
                                                        <path class="cls-1"
                                                            d="M12,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,12,9Z" />
                                                        <path class="cls-1"
                                                            d="M15,18a1,1,0,0,0,2,0V10a1,1,0,0,0-2,0Z" />
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
            </div>

            <div class="flex gap-4 items-center px-2 py-3 border-b border-[#c1c1c1]">
                <div class="text-xl font-semibold dark:text-white">Etudiants</div>
                <div class="bg-white text-[#707FDD] dark:bg-gray-800  rounded-full px-2 py-1">
                    {{ $class->students->count() }}
                </div>
                <div class="w-full flex justify-end items-center">
                    <button wire:click="$toggle('addingStudent')"
                        class="h-11 w-48 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                        Ajouter un étudiant</button>
                </div>
            </div>
            <div>
                {{-- ? class students table --}}
                <table class="w-full border-separate border-spacing-y-2 text-center text-sm dark:text-gray-100">
                    <thead class="text-[#ACACAC] text-sm font-semibold">
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>CNE</th>
                            <th>Absences</th>
                            <th class="w-2/12">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr x-data="{ editing: @entangle('editingStudent'), deleting: @entangle('deletingStudent'), editingStudentId: @entangle('editingStudentId'), deletingStudentId: @entangle('deletingStudentId'), editingStudentClass: @entangle('editingStudentClass') }" wire:key={{ $student->id }}
                                class="h-20 bg-white dark:bg-gray-800">
                                <td class="rounded-l-[30px] w-24">
                                    <img class=" h-12 w-12 rounded-full shadow-md shadow-black ml-6"
                                        src="{{ $student->user->profilePicUrl() }}"
                                        alt="{{ $student->user->name }}">

                                </td>
                                <td class="text-indigo-500 font-semibold">
                                    <a wire:navigate href="{{ route('etudiant.profile', $student->user->id) }}">
                                        {{ $student->user->name }}
                                    </a>
                                </td>
                                <td class="">{{ $student->CNE }}</td>
                                <td class="">{{ $student->absent_sessions }} Seances</td>
                                <td class="rounded-r-[30px]">
                                    <div class="w-full flex justify-center gap-2">
                                        <div>
                                            <button
                                                @click="editing = true; editingStudentId = '{{ $student->id }}'; editingStudentClass = '{{ $student->classe->id }}';"
                                                class="h-10 w-10 p-3 rounded-[15px] bg-indigo-500 text-white hover:text-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                                                <svg class="feather feather-edit fill-none" stroke="currentColor"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="deleting = true; deletingStudentId = '{{ $student->id }}';"
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-dialog-modal wire:model.live="deletingClass">
        <x-slot name="title">
            {{ __('Supprimer la classe') }}
        </x-slot>

        <x-slot name="content">
            {{ __('La classe sera définitivement supprimée') }}

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
            <x-secondary-button wire:click="$toggle('deletingClass')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="delete" class="ml-2" wire:loading.attr="disabled">
                {{ __('Supprimer') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="addingTeacher">
        <x-slot name="title">
            {{ __('Affecter un nouveau professeur') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Veuillez choisir quel professeur et quel module il vas être en charge sur.') }}

            <div class="mt-4 flex flex-col gap-4">

                <div class="flex flex-col gap-1">
                    <label for="professeur">Professeur:</label>
                    <select name="professeur" wire:model.blur="newProfesseur"
                        class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Selectionner un professeur</option>
                        @foreach (App\Models\Teacher::all() as $professeur)
                            <option value="{{ $professeur->id }}">{{ $professeur->user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="newProfesseur" class="mt-2" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="module">Module:</label>
                    <select name="module" wire:model.blur="profModule"
                        class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Selectionner module</option>
                        @foreach ($class->major->modules as $module)
                            <option value="{{ $module->id }}">{{ $module->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="profModule" class="mt-2" />
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('addingTeacher')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="affecteTeacher" class="ml-2" wire:loading.attr="disabled">
                {{ __('Ajouter') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="deletingTeacher">
        <x-slot name="title">
            {{ __('Retirer professeur') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Le professeur sera just retirer de cette classe, si vous souhaitez supprimer le professeur définitivement veuillez visiter son profile.') }}

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
            <x-secondary-button wire:click='cancelDeleting' wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="deleteTeacherFromClass" class="ml-2" wire:loading.attr="disabled">
                {{ __('Retirer') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="addingStudent">
        <x-slot name="title">
            {{ __('Ajouter un étudiant') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Veuillez choisir quel étudiant à ajouté a cette classe.') }}

            <div class="mt-4 flex flex-col gap-4">

                <div class="flex flex-col gap-1">
                    <label for="etudiant">Etudiant:</label>
                    <select name="etudiant" wire:model.blur="newEtudiant"
                        class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Selectionner un etudiant</option>
                        @foreach (App\Models\Student::all() as $etudiant)
                            <option value="{{ $etudiant->id }}">{{ $etudiant->user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="newEtudiant" class="mt-2" />
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('addingStudent')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="ajouterEtudiant" class="ml-2" wire:loading.attr="disabled">
                {{ __('Ajouter') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="editingStudent">
        <x-slot name="title">
            {{ __('Transférer étudiant') }}
        </x-slot>

        <x-slot name="content">
            {{ __("L'étudiant sera transférer vers une autre classe.") }}

            <div class="mt-4 flex flex-col gap-4" x-data="{}">
                <div class="flex flex-col gap-1">
                    <label for="class">Classes du filière:</label>
                    <select name="class" wire:model="editingStudentClass"
                        class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                        <option>Selectionner classe</option>
                        @foreach ($class->major->classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="editingStudentClass" class="mt-2" />
                </div>

                <div class="flex flex-col gap-1">
                    <label for="password">Entrer votre mot de passe:</label>
                    <x-input-password class="mt-1 block" wire:model="adminPassword" wire:keydown.enter="delete" />


                    <x-input-error for="adminPassword" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('editingStudent')" wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="ChangeStudentClasse" class="ml-2" wire:loading.attr="disabled">
                {{ __('transférer') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
    <x-dialog-modal wire:model.live="deletingStudent">
        <x-slot name="title">
            {{ __('Retirer étudiant') }}
        </x-slot>

        <x-slot name="content">
            {{ __("L'étudiant sera just retirer de cette classe, si vous souhaitez supprimer l'étudiant définitivement veuillez visiter son profile.") }}

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
            <x-secondary-button wire:click='cancelDeleting' wire:loading.attr="disabled">
                {{ __('Annuler') }}
            </x-secondary-button>
            <x-button wire:click="deleteStudentFromClasse" class="ml-2" wire:loading.attr="disabled">
                {{ __('Retirer') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
