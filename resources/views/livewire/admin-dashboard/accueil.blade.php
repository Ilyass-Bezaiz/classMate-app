<div class=" w-full pt-8 pb-24 px-8 h-screen overflow-y-auto">
  {{-- ? Absence part --}}
  <div class="mb-6">
    <h2 class="text-[#1F384C] text-[20px] font-medium dark:text-white">Analyses des absences</h2>
    <div class="flex w-full items-start justify-between pl-2 mt-5 gap-5 overflow-x-auto pb-3">
      {{-- *?students absence* --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 flex-shrink-0">
        <h5 class="font-semibold text-[20px] dark:text-white">les étudiant les plus absents</h5>
        <span class="font-light text-sm text-[#959595]">Ces données sont mensuelles</span>
        <div class="mt-6">
          @foreach ($students as $student)
            <div class="flex justify-between items-center mt-4 p-2 border-b dark:border-gray-700">
              <div class="flex items-center gap-5 ">
                <img class="w-8 h-8 bg-gray-400 rounded-full" src="{{ $student->student->user->profilePicUrl() }}"
                  alt="{{ $student->student->user->name }}">
                <div class="dark:text-white text-sm">{{ $student->student->user->name }}</div>
              </div>

              <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $student->count }} Seances</div>
            </div>
          @endforeach
        </div>
      </div>
      {{-- *?teachers absence* --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 flex-shrink-0">
        <h5 class="font-semibold text-[20px] dark:text-white">les professeurs les plus absents</h5>
        <span class="font-light text-sm text-[#959595]">Ces données sont mensuelles</span>
        <div class="mt-6">
          @foreach ($teachers as $teacher)
            <div class="flex justify-between items-center mt-4 p-2 border-b dark:border-gray-700">
              <div class="flex items-center gap-5 ">
                <img class="w-8 h-8 bg-gray-400 rounded-full object-cover"
                  src="{{ $teacher->teacher->user->profilePicUrl() }}" alt="{{ $teacher->teacher->user->name }}">
                <div class="dark:text-white text-sm">{{ $teacher->teacher->user->name }}</div>
              </div>

              <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $teacher->duration }} Jours</div>
            </div>
          @endforeach
        </div>
      </div>
      {{--  ? chart here
            TODO: fill this dev with absence chart --}}
      <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 flex-shrink-0 w-1/2 self-stretch">
        <h1 class="text-xl font-semibold mb-6 dark:text-white">Absences</h1>
        @livewire('admin-dashboard.accueil-chart')
      </div>
    </div>
    {{-- ? Exams part --}}
    <div>
      <h2 class="text-[#1F384C] text-[20px] font-medium dark:text-white">Examens récement ajoutés</h2>
      <div class="flex flex-wrap w-full gap-12 items-start pl-2 mt-5 gap-y-5">
        @foreach ($exams as $exam)
          <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-72 min-h-56 relative shadow-md">
            <h2 class="dark:text-white text-[20px] font-extrabold text-ellipsis">{{ $exam->module->name }}</h2>
            <div class="text-[20px] font-extrabold mt-3 text-wrap">
              <p class="text-gray-500 dark:text-gray-400">Par:
                <span class="text-gray-900 dark:text-blue-400 ">{{ $exam->teacher->user->name }}</span>
              </p>
            </div>
            <div
              class="font-bold absolute bottom-4 right-4 mt-6 text-right px-5 py-2 bg-gray-100 dark:bg-gray-700 rounded-full">
              <span class="text-gray-500 dark:text-gray-400">le: &nbsp;&nbsp;</span>
              <span class="text-blue-600 dark:text-blue-400">{{ $exam->date->format('d M, Y') }}</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  </div>
