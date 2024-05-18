<x-app-layout>
    <div class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
        {{-- Profile details --}}
        <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
            <div class="flex flex-col h-full w-1/4 justify-start items-center gap-3 mt-4">
                <img height="102" width="102" class="rounded-full shadow-md shadow-black"
                    src="{{ Auth::user()->profile_photo_url }}">
                <h1 class="font-bold">
                    {{ $etudiant->name }}
                </h1>
                <div class="rounded-[30px] bg-violet-100 dark:bg-gray-700 py-1 px-4">
                    <h3 class="text-[#707FDD] text-sm">
                        Etudiant
                    </h3>
                </div>
            </div>
            <div class="flex items-center gap-4 flex-col flex-1">
                {{-- details --}}
                <div class="flex justify-center items-center gap-4">
                    <div>
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="email">Email</label>
                        <div
                            class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
                            <p class="text-[#707FDD] font-semibold cursor-pointer text-sm">{{ $etudiant->email }}</p>
                        </div>
                    </div>
                    <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                    <div>
                        {{-- TODO add phone in db --}}
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="phone">Téléphone</label>
                        <div
                            class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
                            <p class="text-gray-800 dark:text-gray-200 text-sm">{{ $etudiant->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between gap-16">
                    <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                </div>
                <div class="flex justify-center items-center gap-4">
                    <div>
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="cne">CNE</label>
                        <div
                            class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]">
                            <p class="text-gray-800 dark:text-gray-200 text-sm">
                                {{ $etudiant->getStudentByUserId($etudiant->id)->CNE }}</p>
                        </div>
                    </div>
                    <hr class="w-16 h-px rotate-90 border-none bg-violet-50 dark:bg-gray-700">
                    <div>
                        {{-- TODO add diplome in db --}}
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="classe">Classe</label>
                        <div
                            class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px] text-center align-middle">
                            <p class="text-[#707FDD] cursor-pointer font-semibold text-sm">
                                {{ $etudiant->getClassByStudentId($etudiant->id)->name }} </p>
                        </div>
                    </div>
                </div>

                {{-- buttons --}}
                <div class="w-full flex justify-end gap-2 mt-4">
                    <button class="h-11 w-48 bg-red-600 text-sm text-white rounded-[30px]">Supprimer</button>
                    <button class="h-11 w-48 bg-[#707FDD] text-sm text-white rounded-[30px]">Modifier</button>
                </div>
            </div>
        </div>
        <div class="flex gap-6">
            <div
                class="flex flex-col w-2/3 h-80 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
                <div class="flex justify-between h-8">
                    <div class="flex items-center gap-2">
                        <h1 class="font-bold">Examens</h1>
                        <div
                            class="flex justify-center items-center bg-violet-100 dark:bg-gray-700 h-full px-4 rounded-[30px]">
                            <p class="text-sm font-bold text-[#707FDD]"></p>
                        </div>
                    </div>

                </div>
                {{-- examens --}}
            </div>
            {{-- TODO Chart --}}
            <div
                class="flex flex-col w-1/3 h-80 gap-4 bg-white dark:bg-gray-800 dark:text-gray-100 rounded-[30px] p-6 ">
                <h1 class="m-auto">CHART</h1>
            </div>
        </div>
    </div>
</x-app-layout>
