  <div class="p-2 w-full overflow-scroll h-screen">
    <x-dialog-modal wire:model.live="showModal">
      <x-slot name="title">
        {{ __('Details') }}
      </x-slot>

      <x-slot name="content">
        @if ($selectedEvent)
          @if ($selectedEvent['type'] == 'exam')
            {{ __("Plus de detail sur l'examen") }}
            <div class="mt-4 flex flex-col gap-4 font-bold" x-data="{}">
              <h2 class="text-lg text-black dark:text-white"> {{ $selectedEvent['title'] }} </h2>
              <div class="text-base">
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">Le professeur : </span>
                  <span class="">{{ $selectedEvent['teacher'] }}</span>
                </p>
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">La classe : </span>
                  <span class="">{{ $selectedEvent['class'] }}</span>
                </p>
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">Date:</span>
                  <span class="">{{ $selectedEvent['start'] }}</span>
                </p>
              </div>
            </div>
          @else
            {{ __("Plus de detail sur l'absence") }}
            <div class="mt-4 flex flex-col gap-4 font-bold" x-data="{}">
              <div class="text-base">
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">Professeur : </span>
                  <span class="">{{ $selectedEvent['teacher'] }}</span>
                </p>
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">De : </span>
                  <span class="">{{ $selectedEvent['start_day'] }}</span>
                </p>
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">Jusq'a : </span>
                  <span class="">{{ $selectedEvent['end_day'] }}</span>
                </p>
                <p class="mb-2">
                  <span class=" text-blue-600 dark:text-blue-400">Pendant :</span>
                  <span class="">{{ $selectedEvent['duration'] }} jours</span>
                </p>
              </div>
            </div>
          @endif
        @else
          <h2 class="text-lg text-black dark:text-white"> Les detailles ne sonr pas disponible ce moment </h2>
        @endif
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
          events: @json($this->events),
          eventClick: function(info) {
            @this.showEventDetails(info.event.id);
          },
        });
        calendar.render();
      });
    </script>
  @endscript
