<x-app-layout>
  <div class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Profile details --}}
    <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
      <div class="flex flex-col h-full w-1/4 justify-start items-center gap-3 mt-4">
        <img class="w-24 h-24 object-cover rounded-full shadow-md shadow-black" src="{{ $etudiant->profilePicUrl() }}">
        <h1 class="font-bold">
          {{ $etudiant->name }}
        </h1>
        <div class="rounded-[30px] bg-violet-100 dark:bg-gray-700 py-1 px-4">
          <h3 class="text-[#707FDD] text-sm">
            Etudiant
          </h3>
        </div>
      </div>
      <div class="flex items-center gap-4 flex-col flex-1">
        {{-- details --}}
        <div class="flex justify-center items-center gap-4">
          <div>
            <label class="font-semibold text-sm text-gray-400 ml-4" for="email">Email</label>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
              <p class="text-[#707FDD] font-semibold cursor-pointer text-sm">{{ $etudiant->email }}</p>
            </div>
          </div>
          <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
          <div>
            {{-- TODO add phone in db --}}
            <label class="font-semibold text-sm text-gray-400 ml-4" for="phone">Téléphone</label>
            <div
              class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
              <p class="text-gray-800 dark:text-gray-200 text-sm">{{ $etudiant->phone }}</p>
            </div>
          </div>
        </div>
        <div class="flex justify-between gap-16">
          <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
          <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
        </div>
        <div class="flex justify-center items-center gap-4">
          <div>
            <label class="font-semibold text-sm text-gray-400 ml-4" for="cne">CNE</label>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
              <p class="text-gray-800 dark:text-gray-200 text-sm">
                {{ $etudiant->getStudentByUserId($etudiant->id)->CNE }}</p>
            </div>
          </div>
          <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
          <div>
            {{-- TODO add diplome in db --}}
            <label class="font-semibold text-sm text-gray-400 ml-4" for="classe">Classe</label>
            <div
              class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
              <p class="text-[#707FDD] cursor-pointer font-semibold text-sm">
                {{ $etudiant->getClassByStudentId($etudiant->id)->name }} </p>
            </div>
          </div>
        </div>

        {{-- buttons --}}
        <div class="w-full flex text-center justify-end gap-2 mt-4">
          <a wire:navigate href="{{ route('etudiant.edit', $etudiant->id) }}"
            class="text-white inline-flex items-center px-4 py-2 bg-[#707FDD] border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Modifier</a>
        </div>
      </div>
    </div>
    <div class="flex gap-6">
      <div class="flex flex-col w-1/2 h-80 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
        <div class="flex justify-between h-8">
          <div class="flex items-center gap-2">
            <h1 class="font-bold">Examens</h1>
            <div class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 h-full px-4 rounded-[30px]">
              <p class="text-sm font-bold text-[#707FDD]"></p>
            </div>
          </div>

        </div>
        {{-- examens --}}
      </div>
      {{-- TODO Chart --}}
      <div class="flex flex-col w-1/2 h-80 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
        {{-- <h1 class="m-auto">CHART</h1> --}}
        <div class="h-full">
          @livewire('admin-dashboard.student-absent-chart', ['user_id' => $etudiant->id])
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
