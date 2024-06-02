  <div class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
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
    {{-- ? Edit Module Modal --}}
    {{-- <x-dialog-modal wire:model.live="editModuleModal">
      <x-slot name="title">
        {{ __('Affecter une module') }}
      </x-slot>

      <x-slot name="content">
        {{ __('Veuillez choisir une module') }}

        <div class="mt-4 flex flex-col gap-4" x-data="{}">
          <div class="flex flex-col gap-1">
            <label for="department">Départements:</label>
            <select name="department" wire:model.live="selectedDepartment" id="department"
              class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
              <option value="">Selectionner Département</option>
              @foreach ($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
              @endforeach
            </select>
            <x-input-error for="department" class="mt-2" />
          </div>
          @if (!empty($allModules))
            <div class="flex flex-col gap-1">
              <label for="module">Les module:</label>
              <select name="class" wire:model="selectedModule" id="module"
                class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                <option value="">Selectionner une module</option>
                @foreach ($allModules as $module)
                  <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
              </select>
              <x-input-error for="selectedModule" class="mt-2" />
            </div>
          @endif
        </div>
      </x-slot>
      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('editModuleModal')" wire:loading.attr="disabled">
          {{ __('Annuler') }}
        </x-secondary-button>
        <x-button wire:click="editModule" class="ml-2" wire:loading.attr="disabled">
          {{ __('Affecter') }}
        </x-button>
      </x-slot>
    </x-dialog-modal> --}}
    {{-- ?Profile details --}}
    <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
      <div class="flex flex-col h-full w-1/4 justify-start items-center gap-3 mt-4">
        <img class="w-24 h-24 object-cover rounded-full shadow-md shadow-black" src="{{ $user->profilePicUrl() }}">
        <h1 class="font-bold">
          {{ $user->name }}
        </h1>
        <div class="rounded-[30px] bg-violet-100 dark:bg-gray-700 py-1 px-4">
          <h3 class="text-[#707FDD] text-sm">
            Professeur
          </h3>
        </div>
      </div>
      <div class="flex w-3/4 items-center gap-4 flex-col flex-1">
        {{-- details --}}
        <div class="flex justify-center items-center gap-4">
          <div>
            <label class="font-semibold text-sm text-gray-400 ml-4" for="email">Email</label>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
              <a href="mailto:{{ $user->email }}" class="text-[#707FDD] font-semibold cursor-pointer text-sm">{{ $user->email }}</a>
            </div>
          </div>
          <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
          <div>
            {{-- TODO add phone in db --}}
            <label class="font-semibold text-sm text-gray-400 ml-4" for="phone">Téléphone</label>
            <div
              class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
              <p class="text-gray-800 dark:text-gray-200 text-sm">{{ $user->phone }}</p>
            </div>
          </div>
        </div>
        <div class="flex justify-between gap-16">
          <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
          <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
        </div>
        <div class="flex justify-center items-center gap-4">
          <div>
            <label class="font-semibold text-sm text-gray-400 ml-4" for="cin">CIN</label>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
              <p class="text-gray-800 dark:text-gray-200 text-sm">
                {{ $user->getTeacherByUserId($user->id)->CIN }}</p>
            </div>
          </div>
          <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
          <div>
            {{-- TODO add diplome in db --}}
            <label class="font-semibold text-sm text-gray-400 ml-4" for="diplome">Diplôme</label>
            <div
              class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
              <p class="text-gray-800 dark:text-gray-200 text-sm">
                {{ $user->getTeacherByUserId($user->id)->diploma }} </p>
            </div>
          </div>
        </div>

        {{-- buttons --}}
        <div class="w-full flex text-center justify-end gap-2 mt-4">
          <a wire:navigate href="{{ route('professeur.edit', $user->id) }}"
            class="text-white inline-flex items-center px-4 py-2 bg-[#707FDD] border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Modifier</a>
        </div>
      </div>
    </div>
    <div class="flex gap-6">
      {{-- <div class="flex flex-col w-1/2 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
        <div class="flex justify-between h-8">
          <div class="flex items-center gap-2">
            <h1 class="font-bold">Modules Affectés</h1>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 h-full px-4 rounded-[30px]">
              <p class="text-sm font-bold text-[#707FDD]">1</p>
            </div>
          </div>
          <button wire:click="$toggle('editModuleModal')"
            class="text-white inline-flex items-center px-4 py-2 bg-[#707FDD] border border-transparent text-sm hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Affecter
            un module</button>
        </div>
        <table class="w-full border-separate border-spacing-y-2 text-center text-sm">
          <thead class="text-gray-400 border">
            <tr>
              <th class="border-b w-1/3 pb-2">Module</th>
              <th class="border-b w-1/3 pb-2">Filiere</th>
              <th class="border-b w-1/3 pb-2">Département</th>
            </tr>
          </thead>
          <tbody>
            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 h-10">
              <td class="rounded-l-md">{{ $teacherModule->name }}</td>
              <td>{{ $teacherModule->getMajorByModuleId($teacherModule->major_id)->name }}
              </td>
              <td class="rounded-r-md">
                {{ $teacherModule->getDepartementByModuleId($teacherModule->major_id)->name }}</td>
            </tr>
          </tbody>
        </table>
      </div> --}}
      <div class="flex flex-col w-1/2 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
        <div class="flex justify-between h-8">
          <div class="flex items-center gap-2">
            <h1 class="font-bold">Les classes Affectés</h1>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 h-full px-4 rounded-[30px]">
              <p class="text-sm font-bold text-[#707FDD]">{{ $classes->count() }}</p>
            </div>
          </div>
          <button wire:click="$toggle('addClassModal')"
            class="text-white inline-flex items-center px-4 py-2 bg-[#707FDD] border border-transparent text-sm hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Affecter
            une classe</button>
        </div>
        <table class="w-full border-separate border-spacing-y-2 text-center text-sm">
          <thead class="text-gray-400 border">
            <tr>
              <th class="border-b w-1/6 pb-2">Classe</th>
              <th class="border-b w-1/3 pb-2">Filiere</th>
              <th class="border-b w-[10%] pb-2">delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($classes as $class)
              <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 h-10">
                <td class="rounded-l-md"><a wire:navigate href="{{ route('classe.show', $class->id) }}">{{ $class->name }}</a></td>
                <td>{{ $class->major->name }}
                </td>
                <td class="rounded-r-md">
                  <button wire:click="delete({{ $class->id }})"
                    class="h-8 w-8 p-2 rounded-[12px] bg-red-500 fill-white hover:fill-red-500 cursor-pointer hover:bg-transparent border border-transparent hover:border-red-500 duration-200">
                    <svg class="feather feather-edit" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path class="cls-1"
                        d="M13,0H11A3,3,0,0,0,8,3V4H2A1,1,0,0,0,2,6H3V20a4,4,0,0,0,4,4H17a4,4,0,0,0,4-4V6h1a1,1,0,0,0,0-2H16V3A3,3,0,0,0,13,0ZM10,3a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V4H10Zm9,17a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6H19Z" />
                      <path class="cls-1" d="M12,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,12,9Z" />
                      <path class="cls-1" d="M15,18a1,1,0,0,0,2,0V10a1,1,0,0,0-2,0Z" />
                      <path class="cls-1" d="M8,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,8,9Z" />
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
                    <p class="text-sm"><span class="text-gray-500">le: </span>{{ $exam->date }}</p>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">Ce professeur n'a pas cree des
              examens</div>
          @endif
        </div>

      </div>
    </div>
  </div>
