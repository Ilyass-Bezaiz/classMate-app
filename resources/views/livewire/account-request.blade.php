<div x-data="{ role: @entangle('role') }"
    class="min-h-screen relative z-50 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <x-authentication-card-logo />
    <div
        class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-[30px]">
        <div class="w-full flex justify-center items-center">
            <div class="w-full flex flex-col">

                <!-- Role -->
                <div class="h-20">
                    {{-- <x-label for="name" value="Je suis:" /> --}}

                    <div class="relative w-1/2 mx-auto bg-gray-300 dark:bg-gray-900 rounded-full flex justify-between items-center mt-2"
                        x-data="selectRoleBar()" x-init="init()">
                        <button @click="setRole($event); role='Teacher'"
                            class="presence-item px-3 text-white font-medium dark:text-gray-200 py-1.5 rounded-full text-[15px] whitespace-nowrap">Professeur</button>
                        {{-- <div @click="setRole($event);"
                            class="presence-item px-1 py-2 rounded-fullwhitespace-nowrap"></div> --}}
                        <button @click="setRole($event); role='Student'"
                            class="presence-item px-3 text-white font-medium dark:text-gray-200 py-1.5 rounded-full text-[15px] whitespace-nowrap">Etudiant</button>
                        <span class="presence-indicator bg-indigo-500" :style="indicatorStyle"></span>
                    </div>
                </div>

                <!-- Name -->
                <div class="h-20">
                    <x-label for="name" value="Nom complet" />
                    <x-input wire:model="name" type="text" name="name" class="text-center text-sm w-full" />
                    <x-input-error for="name" />
                </div>

                <!-- Email -->
                <div class="h-20">
                    <x-label for="email" value="Email" />
                    <x-input type="email" wire:model="email" type="email" name="email"
                        class="text-center text-sm w-full" />
                    <x-input-error for="email" />
                </div>

                <!-- CIN -->
                <div x-show="role === 'Teacher'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="h-20">
                    <x-label for="CIN" value="CIN" />
                    <x-input wire:model="CIN" type="text" name="CIN" class="text-center text-sm w-full" />
                    <x-input-error for="CIN" />
                </div>

                <!-- Diplome -->
                <div x-show="role === 'Teacher'" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="h-20">
                    <x-label for="diploma" value="Diplôme" />
                    <x-input wire:model="diploma" name="diploma" class="text-center text-sm w-full" />
                    <x-input-error for="diploma" />
                </div>

                <!-- CNE -->
                <div x-show="role === 'Student'" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="h-20">
                    <x-label for="CNE" value="CNE" />
                    <x-input wire:model="CNE" type="text" name="CNE" class="text-center text-sm w-full" />
                    <x-input-error for="CNE" />
                </div>

                <!-- Classe -->
                <div x-show="role === 'Student'" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="h-20">
                    <x-label for="classe">Classe</x-label>
                    <x-select wire:model='classe' name="classe" class="text-sm w-full text-center">
                        <x-slot name="options">
                            <option class="text-indigo-500" value="">Tout les classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <x-input-error for="classe" />
                </div>

            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Déjà inscrit ?') }}
            </a>

            <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-100"
                x-transition:enter-end="opacity-100" x-show="role === 'Teacher'">
                <x-button wire:click="sendTeacherRequest" class="ms-4">
                    {{ __('Demander') }}
                </x-button>
            </div>
            <div x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-100"
                x-transition:enter-end="opacity-100" x-show="role === 'Student'">
                <x-button wire:click="sendStudentRequest" class="ms-4">
                    {{ __('Demander') }}
                </x-button>
            </div>
        </div>

        {{-- bg cards --}}
        <div class="w-[45%] h-[900px] bg-indigo-500 fixed -left-80 -top-72 rounded-[60px] -z-50 pt-14 rotate-45">
        </div>
        <div class="w-[300px] h-[300px] bg-indigo-500 fixed left-8 -bottom-44 rounded-[40px] -z-50 pt-14 rotate-45">
        </div>
        <div class="w-[300px] h-[300px] bg-indigo-500 fixed -right-44 -bottom-44 -z-50 pt-14 rotate-45">
        </div>

    </div>
    <x-loading />
</div>
@script
    <script>
        Alpine.data('selectRoleBar', () => {
            return {
                indicatorStyle: {
                    width: '0px',
                    height: '0px',
                    left: '0px',
                    top: '0px',
                },
                setRole(event) {
                    const target = event.target;
                    this.updateIndicator(target);
                },
                updateIndicator(el) {
                    this.indicatorStyle = {
                        width: `${el.offsetWidth}px`,
                        height: `${el.offsetHeight}px`,
                        left: `${el.offsetLeft}px`,
                        top: `${el.offsetTop}px`,
                    };

                    document.querySelectorAll('.presence-item').forEach(item => {
                        // item.classList.remove('text-white');
                        item.classList.add('text-white');
                    });

                    el.classList.add('text-white');
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
