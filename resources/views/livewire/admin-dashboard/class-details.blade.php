<div class="pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- ? Main vertical div contain 3 sections --}}
    <div class="flex flex-col gap-7">
        {{-- ? 1st horixental dev contain 2 div => chart and infos --}}
        <div class="flex gap-4 items-center">
            <div class=" rounded-[30px] p-8 bg-white dark:bg-gray-800 dark:text-gray-100">
                <div class="text-xl font-semibold mb-3">Classe Infos</div>
                <div class="flex items-center gap-4 flex-col flex-1">
                    {{-- details --}}
                    <div class="flex justify-center items-center gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="name">Classe</label>
                            @if ($isEditing)
                                <input wire:model="name" name="name" type="text"
                                    class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-[30px] mx-auto text-sm block w-72 h-11 p-2.5">

                                @error('name')
                                    <span class="text-red-500 text-xs block">{{ $message }}</span>
                                @enderror
                            @else
                                <div
                                    class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
                                    <p class="text-[#707FDD] font-semibold cursor-pointer text-sm">{{ $class->name }}
                                    </p>
                                </div>
                            @endif
                        </div>
                        <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                        <div>
                            {{-- TODO add phone in db --}}
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="department">Département</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
                                <p class="text-gray-800 dark:text-gray-200 text-sm">
                                    {{ $class->major->department->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between gap-16">
                        <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                        <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    </div>
                    <div class="flex justify-center items-center gap-4">
                        <div>
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="major">Filière</label>
                            @if ($isEditing)
                                <select wire:model="classFil"
                                    class="h-[34px] w-32 rounded-[15px] outline-none border-none text-sm pl-4 bg-gray-100 dark:bg-gray-900 dark:text-gray-100">
                                    @foreach ($filieres as $fil)
                                        <option value="{{ $fil->id }}">{{ $fil->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div
                                    class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
                                    <p class="text-gray-800 dark:text-gray-200 text-sm">
                                        {{ $class->major->name }}</p>
                                </div>
                            @endif
                        </div>
                        <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                        <div>
                            {{-- TODO add diplome in db --}}
                            <label class="font-semibold text-sm text-gray-400 ml-4" for="students_number">Nombre
                                d'etudiants</label>
                            <div
                                class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
                                <p class="text-[#707FDD] cursor-pointer font-semibold text-sm">
                                    {{ $class->students->count() }} </p>
                            </div>
                        </div>
                    </div>

                    {{-- buttons --}}
                    <div class="w-full flex justify-end gap-2 mt-4">
                        <button
                            class="h-11 w-48 bg-red-500 rounded-[30px] text-white border border-transparent hover:border-red-500 hover:bg-transparent hover:text-red-500 text-sm font-semibold duration-200">
                            Supprimer</button>
                        <button wire:click="edit({{ $class->id }})"
                            class="h-11 w-48 bg-indigo-500 rounded-[30px] text-white border border-transparent hover:border-indigo-500 hover:bg-transparent hover:text-indigo-500 text-sm font-semibold duration-200">
                            Modifier</button>
                    </div>
                </div>
            </div>
            <div class="w-1/3 rounded-[30px] p-8 bg-white dark:bg-gray-800 dark:text-gray-100">chart</div>
        </div>
        {{-- ? 2nd dev --}}
        {{-- <div class="flex gap-4 items-center">
      <div>test</div>
    </div> --}}
        {{-- ? 3rd dev class students --}}
        <div class="flex flex-col gap-5">
            <div class="flex gap-4 items-center px-2 py-3 border-b border-[#c1c1c1]">
                <div class="text-xl font-semibold dark:text-white">Etudiants</div>
                <div class="bg-white text-[#707FDD] dark:bg-gray-800  rounded-full px-2 py-1">
                    {{ $class->students->count() }}
                </div>
            </div>
            <div>
                <table class="w-full border-separate border-spacing-y-2 text-center text-sm dark:text-gray-100">
                    <thead class="text-[#ACACAC] text-sm font-semibold">
                        <tr>
                            <th></th>
                            <th>Nom</th>
                            <th>CNE</th>
                            <th>Email</th>
                            <th>Absences</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr wire:key={{ $student->id }} class="h-20 bg-white dark:bg-gray-800">
                                <td class="rounded-l-[30px] w-24">
                                    <img class=" h-12 w-12 rounded-full shadow-md shadow-black ml-6"
                                        src="{{ $student->user->profilePicUrl() }}" alt="{{ $student->user->name }}">

                                </td>
                                <td class="">{{ $student->user->name }}</td>
                                <td class="">{{ $student->CNE }}</td>
                                <td class="">{{ $student->user->email }}</td>
                                <td class="">{{ $student->absent_sessions }} Seances</td>
                                <td class="w-16 rounded-r-[30px] text-end fill-none ">
                                    <a wire:navigate href="{{ route('etudiant.profile', $student->user->id) }}">
                                        <svg class="cursor-pointer dark:fill-gray-700" width="35" height="36"
                                            viewBox="0 0 35 36" xmlns="http://www.w3.org/2000/svg">
                                            <g filter="url(#filter0_d_29_1282)">
                                                <path
                                                    d="M1 16.5C1 7.3873 8.3873 0 17.5 0C26.6127 0 34 7.3873 34 16.5C34 25.6127 26.6127 33 17.5 33C8.3873 33 1 25.6127 1 16.5Z"
                                                    fill="#FBFCFE" />
                                                <path
                                                    d="M1.25 16.5C1.25 7.52537 8.52537 0.25 17.5 0.25C26.4746 0.25 33.75 7.52537 33.75 16.5C33.75 25.4746 26.4746 32.75 17.5 32.75C8.52537 32.75 1.25 25.4746 1.25 16.5Z"
                                                    stroke="#DDE4F0" stroke-width="0.5" />
                                            </g>
                                            <path
                                                d="M14.0898 20.7617L18.661 16.6569L14.0898 12.5522L15.0041 10.9103L21.4037 16.6569L15.0041 22.4036L14.0898 20.7617Z"
                                                fill="#707FDD" />
                                            <defs>
                                                <filter id="filter0_d_29_1282" x="0" y="0" width="35" height="36"
                                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                        result="hardAlpha" />
                                                    <feOffset dy="2" />
                                                    <feGaussianBlur stdDeviation="0.5" />
                                                    <feColorMatrix type="matrix"
                                                        values="0 0 0 0 0.25098 0 0 0 0 0.282353 0 0 0 0 0.321569 0 0 0 0.05 0" />
                                                    <feBlend mode="normal" in2="BackgroundImageFix"
                                                        result="effect1_dropShadow_29_1282" />
                                                    <feBlend mode="normal" in="SourceGraphic"
                                                        in2="effect1_dropShadow_29_1282" result="shape" />
                                                </filter>
                                            </defs>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
