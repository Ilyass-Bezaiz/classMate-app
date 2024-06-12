<div class="flex flex-col gap-4 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Search Section --}}
    <div class="flex justify-between items-center">
        <div class="flex items-center relative">
            <svg class="absolute top-3 left-3" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.95349 16.5194C10.738 16.519 12.471 15.9217 13.8767 14.8224L18.2963 19.2418L19.7178 17.8203L15.2983 13.4009C16.3981 11.9952 16.9959 10.2618 16.9963 8.47698C16.9963 4.0426 13.3881 0.43457 8.95349 0.43457C4.51886 0.43457 0.910645 4.0426 0.910645 8.47698C0.910645 12.9114 4.51886 16.5194 8.95349 16.5194ZM8.95349 2.44517C12.2802 2.44517 14.9856 5.15044 14.9856 8.47698C14.9856 11.8035 12.2802 14.5088 8.95349 14.5088C5.62677 14.5088 2.92136 11.8035 2.92136 8.47698C2.92136 5.15044 5.62677 2.44517 8.95349 2.44517Z"
                    fill="#959595" />
            </svg>
            <input wire:model.live.debounce.300ms='search'
                class="h-[44px] w-[303px] px-10 outline-none rounded-[30px] border-none text-sm dark:bg-gray-800 dark:text-gray-100"
                type="serach" placeholder="Rechercher">
        </div>
        <div x-data="selectDateBar()" x-init="init()"
            class="relative bg-white dark:bg-gray-800 rounded-full flex items-center gap-4 py-2 px-3">
            @foreach ($dates as $date)
                <button wire:key @if ($date['date'] === Carbon\Carbon::today()->toDateString())  x-effect="updateIndicator($el);" @endif
                    :class="selectedDate === '{{ $date['date'] }}' ? 'text-white' : 'text-gray-600'"
                    class="date-item px-2.5 py-1 rounded-full font-medium whitespace-nowrap"
                    @click="setActive($event);selectedDate = '{{$date['date']}}'; $wire.changeDate(selectedDate);">{{ $date['formatted'] }}</button>
            @endforeach
            <span class="date-indicator bg-indigo-500" :style="indicatorStyle"></span>
        </div>

    </div>
    <div class="w-full flex justify-between items-center mt-2">
        <div class="relative bg-white dark:bg-gray-800 rounded-full flex gap-2 items-center py-2 px-3"
            x-data="selectClassBar()" x-init="init()">
            @foreach ($classes as $class)
                <button wire:key class="class-item px-2.5 py-1 rounded-full font-medium whitespace-nowrap"
                    :class="selectedClassId === {{ $class->id }} ? 'text-white' : 'text-gray-600'"
                    @click="setActive($event); $wire.changeClass({{ $class->id }})">{{ $class->name ?? 'Acunne classe' }}</button>
            @endforeach
            <span class="class-indicator bg-indigo-500" :style="indicatorStyle"></span>
        </div>
        <div class="w-full flex justify-end items-center gap-2">
            <select name="sessionPeriod" wire:model.live="sessionPeriod"
                class="h-[44px] px-6 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                <option class="dark:bg-gray-800" value="1">1 Heure</option>
                <option class="dark:bg-gray-800" value="2">2 Heures</option>
                <option class="dark:bg-gray-800" value="3">3 Heures</option>
                <option class="dark:bg-gray-800" value="4">4 Heures</option>
                <option class="dark:bg-gray-800" value="5">5 Heures</option>
            </select>
        </div>
    </div>
    <hr class="mb-4 w-200px border-none h-px bg-gray-200 dark:bg-gray-800" />

    <div class="w-full grid grid-cols-4 gap-4">
        @foreach ($students as $student)
            <div wire:key
                class="flex flex-col items-center justify-center gap-2 bg-white dark:bg-gray-800 rounded-[30px] py-4 px-4 text-gray-900 dark:text-gray-100">
                <img class="w-20 h-20 object-cover rounded-full shadow-md shadow-black"
                    src="{{ $student->user->profilePicUrl() }}">
                <h2 class="font-bold">{{ $student->user->name }}</h2>
                {{-- Absence indicator --}}
                    <div class="relative bg-gray-300 dark:bg-gray-900 rounded-full flex justify-between items-center mt-2"
                        x-data="selectAbsenceBar()" x-init="init()" >
                        <button @if ($this->checkAbsence($student->id) === 'present')  x-effect="updateIndicator($el);" @endif
                            class="presence-item px-3 text-white font-medium dark:text-gray-200 py-1.5 rounded-full text-[15px] whitespace-nowrap"
                            @click="setAbsence($event); $wire.marqueAbsence({{ $student->id }}, false)"
                            color-data="#4CAF50">Présent</button>
                        <div @if ($this->checkAbsence($student->id) === 'unrecorded')  x-effect="updateIndicator($el);" @endif
                            class="presence-item px-1 py-2 rounded-fullwhitespace-nowrap" color-data="#3F51B5"></div>
                        <button @if ($this->checkAbsence($student->id) === 'absent')  x-effect="updateIndicator($el);" @endif
                            class="presence-item px-3 text-white font-medium dark:text-gray-200 py-1.5 rounded-full text-[15px] whitespace-nowrap"
                            @click="setAbsence($event); $wire.marqueAbsence({{ $student->id }}, true)"
                            color-data="#F44336">Absent</button>
                        <span class="presence-indicator" :style="indicatorStyle"></span>
                    </div>
            </div>
        @endforeach
    </div>

    <x-loading />

</div>


@script
    <script>

        Alpine.data('selectDateBar', () => {
            return {
                selectedDate: @entangle('selectedDate'),
                indicatorStyle: {
                    width: '0px',
                    height: '0px',
                    left: '0px',
                    top: '0px',
                },
                setActive(event) {
                    const target = event.target;
                    this.updateIndicator(target);
                },
                updateIndicator(el) {
                    this.indicatorStyle = {
                        width: `${el.offsetWidth}px`,
                        height: `${el.offsetHeight}px`,
                        left: `${el.offsetLeft}px`,
                        top: `${el.offsetTop}px`
                    };

                    document.querySelectorAll('.date-item').forEach(item => {
                        item.classList.remove('text-white');
                        item.classList.add('text-gray-600');
                    });

                    el.classList.add('text-white');
                },
                init() {
                    const firstItem = document.querySelector('.date-item');
                    if (firstItem) {
                        this.updateIndicator(firstItem);
                    }
                }
            }
        });

        Alpine.data('selectClassBar', () => {
            return {
                selectedClassId: @entangle('selectedClassId'),
                indicatorStyle: {
                    width: '0px',
                    height: '0px',
                    left: '0px',
                    top: '0px',
                },
                setActive(event) {
                    const target = event.target;
                    this.updateIndicator(target);
                },
                updateIndicator(el) {
                    this.indicatorStyle = {
                        width: `${el.offsetWidth}px`,
                        height: `${el.offsetHeight}px`,
                        left: `${el.offsetLeft}px`,
                        top: `${el.offsetTop}px`
                    };

                    document.querySelectorAll('.class-item').forEach(item => {
                        item.classList.remove('text-white');
                        item.classList.add('text-gray-600');
                    });

                    el.classList.add('text-white');
                },
                init() {
                    const firstItem = document.querySelector('.class-item');
                    if (firstItem) {
                        this.updateIndicator(firstItem);
                    }
                }
            }
        });

        Alpine.data('selectAbsenceBar', () => {
            return {
                indicatorStyle: {
                    width: '0px',
                    height: '0px',
                    left: '0px',
                    top: '0px',
                },
                setAbsence(event) {
                    const target = event.target;
                    this.updateIndicator(target);
                },
                updateIndicator(el) {
                    this.indicatorStyle = {
                        width: `${el.offsetWidth}px`,
                        height: `${el.offsetHeight}px`,
                        left: `${el.offsetLeft}px`,
                        top: `${el.offsetTop}px`,
                        backgroundColor: `${el.getAttribute('color-data')}`
                    };

                    // document.querySelectorAll('.presence-item').forEach(item => {
                    //     // item.classList.remove('text-white');
                    //     item.classList.add('text-white');
                    // });

                    // el.classList.add('text-white');
                },
                init() {
                    // console.log($studentId);
                    let activeItem = document.querySelector('.presence-item');
                    if (activeItem) {
                        this.updateIndicator(activeItem);
                    }
                }
            }
        });
    </script>
@endscript
