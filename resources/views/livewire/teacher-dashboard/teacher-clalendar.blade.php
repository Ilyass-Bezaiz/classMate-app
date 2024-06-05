  <div class="p-2 w-full overflow-scroll h-screen">
    {{-- <x-loading /> --}}
    <x-dialog-modal wire:model.live="showModal">
      <x-slot name="title">
        {{ __('Detail Examen') }}
      </x-slot>

      <x-slot name="content">
        {{ __("Plus de detail sur l'examen") }}

        <div class="mt-4 flex flex-col gap-4 font-bold" x-data="{}">
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
          {{ __('Annuler') }}
        </x-secondary-button>
      </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="MarkAbsenceModal">
      <x-slot name="title">
        {{ __("Confirmer L'absence") }}
      </x-slot>

      <x-slot name="content">
        {{ __('Veuillez confirmer la durée de votre absence') }}

        <div class="mt-4 flex flex-col gap-4 font-bold" x-data="{}">
          @if ($selectedDuration)
            {{-- <h2 class="text-lg text-black dark:text-white"> {{ $selectedDuration['title'] }} </h2> --}}
            <div class="text-base">
              <p class="mb-2">
                <span class=" text-blue-600 dark:text-blue-400">De : </span>
                <span class="">{{ $selectedDuration['start'] }}</span>
              </p>
              <p class="mb-2">
                <span class=" text-blue-600 dark:text-blue-400">Jusq'a : </span>
                <span class="">{{ $selectedDuration['end'] }}</span>
              </p>
              <p class="mb-2">
                <span class=" text-blue-600 dark:text-blue-400">Pendant :</span>
                <span class="">{{ $selectedDuration['duration'] }} jours</span>
              </p>
            </div>
          @else
            <h2 class="text-lg text-black dark:text-white"> Les detailles ne sont pas disponible ce moment </h2>
          @endif
        </div>
      </x-slot>
      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('MarkAbsenceModal')" wire:loading.attr="disabled">
          {{ __('Annuler') }}
        </x-secondary-button>
        <x-button wire:click="confirmAbsence" class="ml-2" wire:loading.attr="disabled">
          {{ __('Confirmer') }}
        </x-button>
      </x-slot>
    </x-dialog-modal>

    <div wire:ignore id="calendar" class="bg-white dark:bg-gray-800 p-4 rounded-tl-[30px] mx-auto overflow-scroll">
    </div>
  </div>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
  @script
    <script>
      document.addEventListener('livewire:initialized', function() {
        console.log('gd');
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
          height: 550,
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
          selectable: true,
          //   contentHeight: 'auto',
          //   dayMaxEvents: true,
          //   selectHelper: true, // Enables the selection helper
          editable: true,
          events: @json($this->getEvents()),
          eventClick: function(info) {
            //   console.log('ngd');
            @this.showExamDetails(info.event.id);
          },
          eventDrop: function(info) {
            // Handle event drop (date change)
            @this.updateExamDate(info.event);
          },
          dateClick: function(info) {
            @this.showCreateExamModal(info.dateStr);
          },
          select: function(info) {
            //   alert('Selected dates: ' + info.startStr + ' to ' + info.endStr);
            @this.showMultipleSelectModal(info.startStr, info.endStr)
          }
        });
        calendar.render();
      });
    </script>
  @endscript
