<x-app-layout>
  <div class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Profile details --}}
    <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
      <div class="flex flex-col h-full w-1/4 justify-start items-center gap-3 mt-4">
        <img height="102" width="102" class="rounded-full shadow-md shadow-black"
          src="{{ Auth::user()->profile_photo_url }}">
        <h1 class="font-bold">
          {{ $professeur->name }}
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
              <p class="text-[#707FDD] font-semibold cursor-pointer text-sm">{{ $professeur->email }}</p>
            </div>
          </div>
          <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
          <div>
            {{-- TODO add phone in db --}}
            <label class="font-semibold text-sm text-gray-400 ml-4" for="phone">Téléphone</label>
            <div
              class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
              <p class="text-gray-800 dark:text-gray-200 text-sm">{{ $professeur->phone }}</p>
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
                {{ $professeur->getTeacherByUserId($professeur->id)->CIN }}</p>
            </div>
          </div>
          <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
          <div>
            {{-- TODO add diplome in db --}}
            <label class="font-semibold text-sm text-gray-400 ml-4" for="diplome">Diplôme</label>
            <div
              class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
              <p class="text-gray-800 dark:text-gray-200 text-sm">Dr. en systeme d'information </p>
            </div>
          </div>
        </div>

        {{-- buttons --}}
        <div class="w-full flex text-center justify-end gap-2 mt-4">
          <a wire:navigate href="{{ route('professeur.edit', $professeur->id) }}"
            class="text-white inline-flex items-center px-4 py-2 bg-[#707FDD] border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Modifier</a>
        </div>
      </div>
    </div>
    <div class="flex gap-6">
      <div class="flex flex-col w-1/2 h-80 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
        <div class="flex justify-between h-8">
          <div class="flex items-center gap-2">
            <h1 class="font-bold">Modules Affectés</h1>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 h-full px-4 rounded-[30px]">
              <p class="text-sm font-bold text-[#707FDD]">{{ $modules->count() }}</p>
            </div>
          </div>
          <button class="h-full px-4 bg-[#707FDD] text-sm text-white rounded-[30px]">Affecter un
            module</button>
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
            @foreach ($modules as $module)
              <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 h-10">
                <td class="rounded-l-md">{{ $module->name }}</td>
                <td>{{ $module->getMajorByModuleId($module->major_id)->name }}
                </td>
                <td class="rounded-r-md">
                  {{ $module->getDepartementByModuleId($module->major_id)->name }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{-- TODO Chart --}}
      <div class="flex flex-col w-1/2 h-80 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
        {{-- <h1 class="m-auto">CHART</h1> --}}
        <div class="h-full">
          @livewire('admin-dashboard.teacher-absent-chart', ['user_id' => $professeur->id])
        </div>
      </div>
    </div>
    {{-- TODO Examens cree par le prof --}}
    <div class="flex flex-col gap-4 ">
      <div class="flex gap-2 items-center ml-6">
        <h1 class="font-bold dark:text-gray-100">Examens Crées</h1>
        <div class="flex justify-center items-center bg-white dark:bg-gray-700 h-full px-4 rounded-[30px]">
          <p class="text-sm font-bold text-[#707FDD]">{{ $modules->count() }}</p>
        </div>
      </div>
      <div class="flex gap-2 w-full h-52 overflow-x-auto">
        {{-- Examen Card --}}
        <div class="flex flex-col w-96 h-full gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-8">
          <h1 class="text-xl font-bold">UML et Gestion de projet</h1>
          <h2><span class="text-gray-500">Classe:</span> LP-Groupe1</h2>
          <div class="h-full flex justify-end items-end">
            <div class="bg-violet-100 cursor-pointer dark:bg-gray-700 rounded-[30px] py-2 px-6">
              <p class="text-sm"><span class="text-gray-500">le: </span>16-12-2024</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>
