  <div x-data="{ editing: @entangle('editing'), deleting: @entangle('deleting'), addClassModal: @entangle('addClassModal') }" class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
      {{-- ?Profile details --}}
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
                      <img src="{{ $teacher->user->profile_photo_url }}" alt="{{ $teacher->user->name }}"
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

                  @if ($teacher->user->profile_photo_path || session('message'))
                      <x-secondary-button x-show="editing" type="button" wire:click.prevent="deleteProfilePhoto">
                          {{ __('Supprimer Photo') }}
                      </x-secondary-button>
                  @endif

                  <x-input-error for="photo" class="mt-2" />
              </div>

              <h1 x-show="!editing" class="font-bold">
                  {{ $teacher->user->name }}
              </h1>
              <div x-show="!editing" class="rounded-[30px] bg-violet-100 dark:bg-gray-700 py-1 px-4">
                  <h3 class="text-[#707FDD] text-sm text-center">
                      Professeur
                  </h3>
              </div>
              <x-input x-show="editing" wire:model="name" class="text-center text-sm rounded-[30px]" />
              <x-input-error for="name" />
          </div>
          <div class="flex w-3/4 items-center gap-4 flex-col flex-1">
              {{-- details --}}
              <div class="flex justify-center items-center gap-4">
                  <div>
                      <x-label for="email" value="Email" />
                      <div class="relative">
                          <x-input name="email" wire:model="email"
                              class="w-72 h-11 text-center text-sm rounded-[30px]" x-bind:disabled="!editing" />
                          <button x-show="editing" wire:click="resetPassword" title="Reset password"
                              class="h-[43px] w-11 p-3 absolute right-0 rounded-r-[30px] bg-indigo-500 fill-white hover:fill-indigo-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-indigo-500 duration-200">
                              <svg stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 125 125">
                                  <path
                                      d="M102.58,84.44a5.07,5.07,0,0,1,8.77,5.08,59.65,59.65,0,0,1-81.15,22,5.83,5.83,0,0,1-.69-.39,59.66,59.66,0,0,1-21.7-81,5.14,5.14,0,0,1,.46-.78A59.63,59.63,0,0,1,89.5,8a59.22,59.22,0,0,1,21.7,21.55l1-3.89a5.42,5.42,0,1,1,10.49,2.71L119,42.69a5.52,5.52,0,0,1-.48,1.23,5.43,5.43,0,0,1-6,3.28L98,44.52a5.42,5.42,0,0,1,2-10.66l2.33.43a49.56,49.56,0,0,0-85.31.37l-.14.26A49.55,49.55,0,0,0,34.9,102.57h0a49.54,49.54,0,0,0,67.66-18.14Zm-22-14.06h0l5.75,5.75h0l3.52,3.52L84.15,85.4l-3.52-3.52-5.57,5.57L69.31,81.7l5.57-5.57-3-3-6.41,6.42-5.75-5.75,6.42-6.42-2-2-2-2,0,0a16.95,16.95,0,0,1-23.92,0h0l-.28-.3a16.92,16.92,0,0,1,.28-23.63h0L44,33.64a16.93,16.93,0,0,1,24,23.93h0l0,0L80.63,70.38ZM61.31,40.23a7.67,7.67,0,0,0-10.77,0L44.73,46h0a7.68,7.68,0,0,0-.19,10.58l.2.19h0a7.68,7.68,0,0,0,10.77,0L61.31,51h0a7.68,7.68,0,0,0,0-10.77Z" />
                              </svg>
                          </button>
                      </div>
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
                      <x-label for="CIN" value="CIN" />
                      <x-input name="CIN" wire:model="CIN" class="w-72 h-11 text-center text-sm rounded-[30px]"
                          x-bind:disabled="!editing" />

                      <x-input-error for="CIN" />
                  </div>
                  <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                  <div>
                      <x-label for="diplome" value="Diplôme" />
                      <x-input name="diplome" wire:model="diplome" class="w-72 h-11 text-center text-sm rounded-[30px]"
                          x-bind:disabled="!editing" />

                      <x-input-error for="diplome" />
                  </div>
              </div>

              {{-- buttons --}}
              <div class="w-full flex text-center justify-end gap-2 mt-4">
                  <x-danger-button x-show="!editing" @click="deleting = true">Supprimer professeur</x-danger-button>
                  <x-button x-show="!editing" @click="editing = true">Modifier</x-button>

                  <x-secondary-button x-show="editing" wire:click="cancelEditing">Annuler</x-secondary-button>
                  <x-button x-show="editing" wire:click="editTeacher">Enregistrer</x-button>
              </div>
          </div>
      </div>
      <div class="flex gap-6">
          <div class="flex flex-col w-1/2 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
              <div class="flex justify-between h-8">
                  <div class="flex items-center gap-2">
                      <h1 class="font-bold">Les classes Affectés</h1>
                      <div
                          class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 h-full px-4 rounded-[30px]">
                          <p class="text-sm font-bold text-[#707FDD]">{{ $classes->count() }}</p>
                      </div>
                  </div>
                  <x-button @click="addClassModal = true;">Affecter une classe</x-button>
              </div>
              <table class="w-full border-separate border-spacing-y-2 text-center text-sm">
                  <thead class="text-gray-400 border">
                      <tr>
                          <th class="border-b w-1/6 pb-2">Classe</th>
                          <th class="border-b w-1/3 pb-2">Filiere</th>
                          <th class="border-b w-[10%] pb-2">Delete</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($classes as $class)
                          <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 h-10">
                              <td class="rounded-l-md"><a wire:navigate
                                      href="{{ route('classe.show', $class->id) }}">{{ $class->name }}</a></td>
                              <td>{{ $class->major->name }}
                              </td>
                              <td class="rounded-r-md">
                                  <button wire:click="deleteClasse({{ $class->id }})"
                                      class="h-8 w-8 p-2 rounded-[12px] bg-red-500 fill-white hover:fill-red-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-red-500 duration-200">
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
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
          {{-- ? Absent Chart --}}
          <div class="w-1/2">
              <div class="h-full bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">
                  @livewire('admin-dashboard.teacher-absent-chart', ['user_id' => $user->id])
              </div>
          </div>
      </div>
      {{-- TODO Examens cree par le prof --}}
      <div class="flex flex-col gap-4 ">
          <div class="flex gap-2 items-center ml-6">
              <h1 class="font-bold dark:text-gray-100">Examens Crées</h1>
              <div class="flex justify-center items-center bg-white dark:bg-gray-700 h-full px-4 rounded-[30px]">
                  <p class="text-sm font-bold text-[#707FDD]">{{ $exams->count() }}</p>
              </div>
          </div>
          <div class="flex gap-4 w-full">
              {{-- Examen Card --}}
              <div class="w-full flex gap-2">
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
                      <div class="bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">Ce professeur n'a
                          pas
                          crée des
                          examens</div>
                  @endif
              </div>

          </div>
      </div>
      {{-- ? Add Class Modal --}}
      <x-dialog-modal wire:model.live="addClassModal">
          <x-slot name="title">
              {{ __('Affecter une classe') }}
          </x-slot>

          <x-slot name="content">
              {{ __('Veuillez choisir une classe') }}

              <div class="mt-4 flex flex-col gap-4" x-data="{}">
                  <div class="flex flex-col gap-1">
                      <label for="class">Les classes:</label>
                      <select name="class" wire:model="classe"
                          class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                          <option value="">Selectionner une classe</option>
                          @foreach ($allClasses as $class)
                              <option value="{{ $class->id }}">{{ $class->name }}</option>
                          @endforeach
                      </select>
                      <x-input-error for="classe" class="mt-2" />
                  </div>
              </div>
          </x-slot>
          <x-slot name="footer">
              <x-secondary-button wire:click="$toggle('addClassModal')" wire:loading.attr="disabled">
                  {{ __('Annuler') }}
              </x-secondary-button>
              <x-button wire:click="addClass" class="ml-2" wire:loading.attr="disabled">
                  {{ __('Ajouter') }}
              </x-button>
          </x-slot>
      </x-dialog-modal>
      {{-- ? Delete Teacher Modal --}}
      <x-dialog-modal wire:model.live="deleting">
          <x-slot name="title">
              {{ __('Supprimer le professeur ') }}
          </x-slot>

          <x-slot name="content">
              {{ __('Le professeur sera définitivement supprimé') }}

              <div class="mt-4 flex flex-col gap-4" x-data="{}">
                  <div class="flex flex-col gap-1">
                      <x-label for="password">Entrer votre mot de passe:</x-label>
                      <x-input-password class="mt-1 block w-3/4" wire:model="adminPassword"
                          wire:keydown.enter="deleteTeacher" />


                      <x-input-error for="adminPassword" class="mt-2" />
                  </div>
              </div>
          </x-slot>

          <x-slot name="footer">
              <x-secondary-button @click="deleting = false" wire:loading.attr="disabled">
                  {{ __('Annuler') }}
              </x-secondary-button>
              <x-danger-button wire:click="deleteTeacher" class="ml-2" wire:loading.attr="disabled">
                  {{ __('Supprimer') }}
              </x-danger-button>
          </x-slot>
      </x-dialog-modal>
      <x-loading />
  </div>
