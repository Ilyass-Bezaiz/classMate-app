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
          {{ __('Annuler') }}
        </x-secondary-button>
      </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model.live="showCreateModal">
      <x-slot name="title">
        {{ __('Ajoutez un evenement') }}
      </x-slot>

      <x-slot name="content">
        {{ __("Veuillez choisir un nom pour l'evenement") }}

        <div class="mt-4 flex flex-col gap-4" x-data="{}">

        </div>
      </x-slot>
      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('showCreateModal')" wire:loading.attr="disabled">
          {{ __('Annuler') }}
        </x-secondary-button>
        <x-button wire:click="" class="ml-2" wire:loading.attr="disabled">
          {{ __('Ajouter') }}
        </x-button>
      </x-slot>
    </x-dialog-modal>

    <div wire:ignore id="calendar">
    </div>
  </div>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
  @script
    {{-- @push('script') --}}
    <script>
      document.addEventListener('livewire:initialized', function() {
        console.log('gd');
        let calendarEl = document.getElementById('calendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
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
          //   selectHelper: true, // Enables the selection helper
          editable: true,
          events: @json($this->getEvents()),
          eventClick: function(info) {
            //   console.log('ngd');
            @this.showExamDetails(info.event.id);
          },
          dateClick: function(info) {
            @this.showCreateExamModal(info.dateStr);
          },
          select: function(info) {
            // Show alert with the start and end dates
            //   alert('Selected dates: ' + info.startStr + ' to ' + info.endStr);
            @this.showMultipleSelectModal(info.startStr, info.endStr)
          }
        });
        calendar.render();
      });
    </script>
    {{-- <script>
      document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar')
        let calendar = new window.Calendar(calendarEl, {
          plugins: [window.dayGridPlugin],
          //   plugins: [window.dayGridPlugin, window.timeGridPlugin, window.listPlugin],
          initialView: 'dayGridMonth',
          locale: esLocale,
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
          }
        })
        calendar.render()
      });
    </script> --}}
  @endscript
