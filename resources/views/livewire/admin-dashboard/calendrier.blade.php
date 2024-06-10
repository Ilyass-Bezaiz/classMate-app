  <div class="p-2 w-full overflow-scroll h-screen">
    <x-dialog-modal wire:model.live="showModal">
      <x-slot name="title">
        {{ __('Detail Examen') }}
      </x-slot>

      <x-slot name="content">
        {{ __("Plus de detail sur l'examen") }}

        <div class="mt-4 flex flex-col gap-4 font-bold" x-data="{}">
          {{-- <p>{{ $currentExam[1] ?? 'err' }}</p> --}}
          @if ($currentExam)
            <h2 class="text-lg text-black dark:text-white"> {{ $currentExam['title'] }} </h2>
            <div class="text-base">
              <p class="mb-2">
                <span class=" text-blue-600 dark:text-blue-400">Le professeur : </span>
                <span class="">{{ $currentExam['teacher'] }}</span>
              </p>
              <p class="mb-2">
                <span class=" text-blue-600 dark:text-blue-400">La classe : </span>
                <span class="">{{ $currentExam['class'] }}</span>
              </p>
              <p class="mb-2">
                <span class=" text-blue-600 dark:text-blue-400">Date:</span>
                <span class="">{{ $currentExam['start'] }}</span>
              </p>
            </div>
          @else
            <h2 class="text-lg text-black dark:text-white"> Les detailles ne sonr pas disponible ce moment </h2>
          @endif
        </div>
      </x-slot>
      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
          {{ __('Fermer') }}
        </x-secondary-button>
      </x-slot>
    </x-dialog-modal>

    <div wire:ignore id="calendar" class="bg-white dark:bg-gray-800 p-4 rounded-tl-[30px] mx-auto overflow-scroll">
    </div>
    <x-loading />

  </div>
  @script
    <script>
      document.addEventListener('livewire:navigated', function() {
        console.log('gd');
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
          height: 560,
          initialView: 'dayGridMonth',
          headerToolbar: {
            start: 'dayGridMonth,timeGridWeek,timeGridDay',
            center: 'title',
            //   end: 'today,prev,next'
          },
          buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour'
          },
          locale: 'fr',
          events: @json($this->getEvents()),
          eventClick: function(info) {
            @this.showExamDetails(info.event.id);
          },
        });
        calendar.render();
      });
    </script>
  @endscript
