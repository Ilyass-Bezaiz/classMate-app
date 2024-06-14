<div class="w-full pt-8 pb-24 px-8 h-screen overflow-y-auto">
  <div class="mb-6">
    <h2 class="text-gray-900 text-xl font-bold dark:text-white ml-6">Vos absences</h2>
    <div class="flex flex-col gap-3 my-5">
      <div class="w-full bg-white dark:bg-gray-800 rounded-[30px] p-4 flex-shrink-0 self-stretch">
        @livewire('teacher-dashboard.Charts.teacher-chart-absent')
      </div>
      <div class="flex w-full items-start gap-3">
        {{-- *?students absence* --}}
        <div class="flex-1 bg-white dark:bg-gray-800 rounded-[30px] p-6 flex-shrink-0">
          <h5 class="text-lg font-semibold dark:text-white">Les étudiant les plus absents</h5>
          <span class="font-light text-sm text-gray-400">Ces données sont mensuelles</span>
          <div class="mt-6">
            @foreach ($students as $student)
              <div
                class="flex justify-between rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 items-center mt-2 p-2 border-b dark:border-gray-700">
                <div class="flex items-center gap-3 ">
                  <img class="w-8 h-8 bg-gray-400 rounded-full" src="{{ $student->student->user->profilePicUrl() }}"
                    alt="{{ $student->student->user->name }}">
                  <a wire:navigate href="{{ route('etudiant.profile', $student->student->user->id) }}"
                    class="dark:text-white text-sm">{{ $student->student->user->name }}</a>
                </div>

                <div class="text-gray-500 dark:text-gray-400 text-[12px]">{{ $student->sessions }} Seances
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      <div>
        <h2 class="text-gray-900 text-xl font-bold dark:text-white ml-6">Examens récement ajoutés</h2>
        <div class="flex min-w-full max-w-[900px] gap-3 items-start pb-2 mt-5 overflow-x-auto">
          @forelse ($exams as $exam)
            <div class="flex flex-col bg-white dark:bg-gray-800 rounded-[30px] p-6 min-w-96 min-h-56 shadow-md">
              <h2 class="flex-1 dark:text-gray-100 text-xl font-semibold">{{ $exam->module->name }}
              </h2>
              <div class="text-lg font-medium mb-4 text-wrap">
                <p class="text-gray-500 dark:text-gray-400">Par:
                  <a wire:navigate href="{{ route('professeur.profile', $exam->teacher->user->id) }}"
                    class="text-indigo-500 ">{{ $exam->teacher->user->name }}</a>
                </p>
              </div>
              <div class="font-semibold ml-auto text-right px-5 py-2 bg-gray-100 dark:bg-gray-700 rounded-full">
                <span class="text-gray-500 dark:text-gray-400">le: &nbsp;&nbsp;</span>
                <span class="text-indigo-500 underline cursor-pointer">{{ $exam->date->format('d M, Y') }}</span>
              </div>
            </div>
          @empty
            <div class="w-full p-4 text-center text-gray-600 font-semibold">
              Vous n'avez pas créer d'examen.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
