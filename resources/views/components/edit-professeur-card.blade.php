<div class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Profile details --}}
    <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
        <div class="flex flex-col h-full w-1/4 justify-start items-center gap-4 mt-4">
            <img height="102" width="102" class="rounded-full shadow-md shadow-black"
                src="{{ Auth::user()->profile_photo_url }}">
            <div class="w-full flex flex-col items-center gap-2">
                <button
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Changer
                    photo</button>
                <button
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Supprimer
                    photo</button>
            </div>
        </div>
        <div class="flex flex-col w-3/4 items-center">
            <div class="flex items-center gap-4">
                {{-- details --}}
                <div class="flex flex-col justify-center items-center gap-6">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="name">Nom</label>
                        <input wire:model="name"
                            class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
                    </div>
                    <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="CIN">CIN</label>
                        <input wire:model="CIN" type="text" name=""
                            class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
                    </div>
                    <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="diplome">Diplôme</label>
                        <input wire:model="diplome"
                            class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
                    </div>
                </div>
                <div class="flex flex-col h-full gap-28 justify-center pt-3">
                    <hr class="w-16 rotate-90 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <hr class="w-16 rotate-90 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <hr class="w-16 rotate-90 h-px border-none bg-violet-50 dark:bg-gray-700">
                </div>
                <div class="flex flex-col justify-center items-center gap-6">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="phone">Téléphone</label>
                        <input wire:model="phone"
                            class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
                    </div>
                    <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="email">Email</label>
                        <input wire:model="email"
                            class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
                    </div>
                    <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
                    <div class="flex flex-col">
                        <label class="font-semibold text-sm text-gray-400 ml-4" for="password">Password</label>
                        <input wire:model="password" type="password"
                            class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
                    </div>
                </div>

            </div>
            {{-- button save --}}
            <div class="w-full flex text-center justify-end mt-6">
                <button wire:click="save"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Enregistrer</button>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">


        <div class="flex justify-between items-center">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Une fois le compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer ce compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
            </div>

            <div class="flex justify-end w-full">
                <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                    {{ __('Supprimer le professeur') }}
                </x-danger-button>
            </div>
        </div>
    </div>
    
</div>
