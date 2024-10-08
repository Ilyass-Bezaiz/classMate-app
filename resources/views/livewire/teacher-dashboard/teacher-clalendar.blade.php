    <div class="p-2 w-full overflow-scroll h-screen">
      {{-- ? Event details modal --}}
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
      {{-- ? add Absence Modal --}}
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
      {{-- ?Edit exam --}}
      <x-dialog-modal wire:model.live="editExamModal">
        <x-slot name="title">
          {{ __("Modifier L'examen") }}
        </x-slot>

        <x-slot name="content">
          {{ __("Veuillez verifier Tout les informations d'examen") }}

          <div class="mt-4 flex flex-col gap-4" x-data="{}">

            <div class="flex flex-col gap-1">
              <label for="classe">choisir la classe:</label>
              <select name="classe" wire:model.live="examClass"
                class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                <option value="">Selectionner classe</option>
                @foreach ($classes as $classe)
                  <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                @endforeach
              </select>
              <x-input-error for="examModule" class="mt-2" />
            </div>

            <div class="flex flex-col gap-1">
              <label for="module">Choisir le module:</label>
              <select name="module" wire:model.live="examModule"
                class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                <option value="">Selectionner Module</option>
                @foreach ($modules as $module)
                  <option value="{{ $module->id }}">{{ $module->name }}</option>
                @endforeach
              </select>
              <x-input-error for="examModule" class="mt-2" />
            </div>

          </div>
        </x-slot>

        <x-slot name="footer">
          <x-secondary-button wire:click="$toggle('editExamModal')">
            {{ __('Annuler') }}
          </x-secondary-button>
          <x-button wire:click="ConfirmEdit" class="ml-2" wire:loading.attr="disabled">
            {{ __('Ajouter') }}
          </x-button>
        </x-slot>
      </x-dialog-modal>
      {{-- ? date click modal --}}

      <x-modal id="dayClickModal" wire:model.live="dayClickModal">
        <div x-data="{ selectedType: 'exam' }">
          <div class="px-6 py-4">
            {{-- header --}}
            <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
              Absence ou examen
            </div>
            {{-- contents --}}
            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
              Choisir si vous voulez ajouter un exam ou une journée d'absence
              <div class="mt-4 flex flex-col gap-4">
                <div class="modal-content mt-4 flex flex-col gap-4">
                  <div class="flex items-center gap-8 text-[15px] font-semibold">
                    <label>
                      <input type="radio" value="exam" x-model="selectedType"> &nbsp;&nbsp;Examen
                    </label>
                    <label>
                      <input type="radio" value="absence" x-model="selectedType"> &nbsp;&nbsp;Absence
                    </label>
                  </div>
                  <!-- Show additional info based on selected type -->
                  <div x-show="selectedType === 'exam'" class="mt-4">
                    <!-- Additional fields for exam -->
                    <div class="flex flex-col gap-1 mb-2">
                      <label for="classe">choisir la classe:</label>
                      <select name="classe" wire:model.live="examClass"
                        class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Selectionner classe</option>
                        @foreach ($classes as $classe)
                          <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                        @endforeach
                      </select>
                      <x-input-error for="examClass" class="mt-2" />
                    </div>

                    <div class="flex flex-col gap-1">
                      <label for="module">Choisir le module:</label>
                      <select name="module" wire:model="examModule"
                        class="w-3/4 rounded-md outline-none border-gray-200 dark:border-gray-700 text-sm pl-4 dark:bg-gray-900 dark:text-gray-100">
                        <option value="">Selectionner Module</option>
                        @foreach ($modules as $module)
                          <option value="{{ $module->id }}">{{ $module->name }}</option>
                        @endforeach
                      </select>
                      <x-input-error for="examModule" class="mt-2" />
                    </div>
                  </div>

                  <div x-show="selectedType === 'absence'">
                    <div class="mt-4 flex flex-col gap-4 font-bold">
                      @if ($selectedDuration)
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
                        <h2 class="text-lg text-black dark:text-white"> Les detailles ne sont pas disponible ce moment
                        </h2>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {{-- footer --}}
          <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-end">
            <x-secondary-button wire:click="$toggle('dayClickModal')">
              {{ __('Annuler') }}
            </x-secondary-button>
            <x-button x-show="selectedType === 'exam'" wire:click="addExam" class="ml-2"
              wire:loading.attr="disabled">
              {{ __('Ajouter Examen') }}
            </x-button>
            <x-button x-show="selectedType === 'absence'" wire:click="confirmAbsence" class="ml-2"
              wire:loading.attr="disabled">
              {{ __('Ajouter Absence') }}
            </x-button>
          </div>
        </div>
      </x-modal>

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
            selectable: true,
            editable: true,
            events: @json($this->events),
            eventDidMount: function(info) {
              const eventType = info.event.extendedProps.type;
              showContextMenu(info);
            },
            eventClick: function(info) {
              @this.showEventDetails(info.event.id);
            },
            eventDrop: function(info) {
              checkDate(info.event.start) ? @this.updateEventDate(info.event) : info.revert();
            },
            eventResize: function(info) {
              if (info.event.extendedProps.type === 'exam') {
                // Prevent resizing
                info.revert();
              } else {
                @this.updateEventDuration(info);
              }
            },
            dateClick: function(info) {
              if (checkDate(info.date)) {
                @this.selectedDate = info.dateStr;
                @this.dayClickModal = true;
              }
            },
            select: function(info) {
              if (checkDate(info.start)) {
                @this.showMultipleSelectModal(info.startStr, info.endStr);
              }
            }
          });
          calendar.render();
          Livewire.on('eventAdded', function(eventJson) {
            const newEvent = JSON.parse(eventJson);
            calendar.addEvent(newEvent);
          });
          Livewire.on('eventDeleted', function(eventID) {
            const event = calendar.getEventById(eventID);
            event.remove();
          });
        });

        function checkDate(date) {
          const today = new Date();
          return date > today;
        }

        function editEvent(info) {
          console.log(info);
        }

        function showContextMenu(info) {
          //   console.log(info.event.start);
          if (!checkDate(info.event.start)) {
            return;
          }
          // Create a new context menu
          let menu = document.createElement('div');
          menu.classList.add(
            'context-menu', 'w-28', 'absolute', 'top-[30px]', 'right-0',
            'z-auto', 'bg-gray-800', 'dark:bg-white', 'border', 'shadow-lg', 'rounded', 'p-2',
            'border-solid', 'border-gray-300', 'hidden', 'transition-opacity', 'duration-300', 'ease-in-out'
          );
          //   let stringObject = JSON.stringify(info.event);
          //   console.log(stringObject);
          if (info.event.extendedProps.type == 'exam') {

            menu.innerHTML = `
            <button onclick="@this.editEvent('${info.event.id}')" class = "font-semibold">
                <span class = 'text-blue-600 '>Edit</span>
                <svg class="feather feather-edit fill-none h-3 w-3" stroke="#0070f3" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
            </button>
            <button onclick="@this.deleteEvent('${info.event.id}')" class = "font-semibold">
                <span class = 'text-red-600 '>Delete</span>
                <svg class="feather feather-edit h-3 w-3 fill-red-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="3">
                    <path class="cls-1" d="M13,0H11A3,3,0,0,0,8,3V4H2A1,1,0,0,0,2,6H3V20a4,4,0,0,0,4,4H17a4,4,0,0,0,4-4V6h1a1,1,0,0,0,0-2H16V3A3,3,0,0,0,13,0ZM10,3a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V4H10Zm9,17a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6H19Z" />
                    <path class="cls-1" d="M12,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,12,9Z" />
                    <path class="cls-1" d="M15,18a1,1,0,0,0,2,0V10a1,1,0,0,0-2,0Z" />
                    <path class="cls-1" d="M8,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,8,9Z" />
                </svg>
            </button>
            `;
          } else if (info.event.extendedProps.type == 'absence') {
            menu.innerHTML = `
            <button onclick="@this.deleteEvent('${info.event.id}')" class = "font-semibold">
                <span class = 'text-red-600 '>Delete</span>
                <svg class="feather feather-edit h-3 w-3 fill-red-600" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="3">
                    <path class="cls-1" d="M13,0H11A3,3,0,0,0,8,3V4H2A1,1,0,0,0,2,6H3V20a4,4,0,0,0,4,4H17a4,4,0,0,0,4-4V6h1a1,1,0,0,0,0-2H16V3A3,3,0,0,0,13,0ZM10,3a1,1,0,0,1,1-1h2a1,1,0,0,1,1,1V4H10Zm9,17a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6H19Z" />
                    <path class="cls-1" d="M12,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,12,9Z" />
                    <path class="cls-1" d="M15,18a1,1,0,0,0,2,0V10a1,1,0,0,0-2,0Z" />
                    <path class="cls-1" d="M8,9a1,1,0,0,0-1,1v8a1,1,0,0,0,2,0V10A1,1,0,0,0,8,9Z" />
                </svg>
            </button>
            `;
          }


          // Append the menu to the event element
          info.el.appendChild(menu);

          info.el.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            menu.classList.replace('hidden', 'block');
          });
          info.el.addEventListener('mouseleave', function() {
            menu.classList.replace('block', 'hidden');
          });
          menu.addEventListener('click', function(event) {
            event.stopPropagation();
          });
        }
      </script>
    @endscript
