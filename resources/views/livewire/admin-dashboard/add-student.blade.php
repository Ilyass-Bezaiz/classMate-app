<div>
  <div class="flex flex-col gap-6 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    <div class="flex gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">
      <form wire:submit.prevent="save" enctype="multipart/form-data" class=" h-full w-1/4">
        <div x-data="{ photoName: null, photoPreview: null }" class=" flex flex-col justify-start items-center gap-4 mt-4">
          <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
            x-on:change="
                        photoName = $refs.photo.files[0].name;
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            photoPreview = e.target.result;
                        };
                        reader.readAsDataURL($refs.photo.files[0]);
                        " />

          <!-- Current Profile Photo -->
          <div x-show="! photoPreview">
            <img src="" alt=" "
              class="rounded-full h-28 w-28 object-cover shadow-md
              shadow-black">
          </div>

          <!-- New Profile Photo Preview -->
          <div x-show="photoPreview" style="display: none;">
            <span class="block rounded-full h-28 w-28 bg-cover bg-no-repeat bg-center"
              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
            </span>
          </div>

          <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
            {{ __('Ajouter Photo') }}
          </x-secondary-button>

          <x-input-error for="photo" class="mt-2" />
        </div>
      </form>
      <div class="flex flex-col w-3/4 items-center">
        <div class="flex items-center gap-4">
          {{-- details --}}
          <div class="flex flex-col justify-center items-center gap-6">
            <div class="flex flex-col">
              <label class="font-semibold text-sm text-gray-400 ml-4" for="name">Nom</label>
              <input wire:model="name" required type="text" name="name"
                class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
              <x-input-error for="name" class="mt-2" />
            </div>
            <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
            <div class="flex flex-col">
              <label class="font-semibold text-sm text-gray-400 ml-4" for="CNE">CNE</label>
              <input wire:model="CNE" type="text" name="CNE" required
                class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
              <x-input-error for="CNE" class="mt-2" />
            </div>
            <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
            <div class="flex flex-col">
              <label class="font-semibold text-sm text-gray-400 ml-4" for="classe">Affecter une classe</label>
              <select wire:model='classe'
                class="w-72 h-11 rounded-[30px] text-sm pl-4 border-gray-400 bg-violet-100 dark:bg-gray-700 dark:text-gray-100"
                name="classe">
                <option class="text-[#707FDD]" value="">Tout les classes</option>
                @foreach ($classes as $class)
                  <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
              </select>
              @error('classe')
                <div class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</div>
              @enderror
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
              <input wire:model="phone" type="tel"
                class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
              <x-input-error for="phone" class="mt-2" />
            </div>
            <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
            <div class="flex flex-col">
              <label class="font-semibold text-sm text-gray-400 ml-4" for="email">Email</label>
              <input wire:model="email" type="email" required
                class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
              <x-input-error for="email" class="mt-2" />
            </div>
            <hr class="w-16 h-px border-none bg-violet-50 dark:bg-gray-700">
            <div class="flex flex-col">
              <label class="font-semibold text-sm text-gray-400 ml-4" for="password">Password</label>
              <input wire:model="password" type="password"
                class="bg-none text-center border-gray-400 outline-none text-sm bg-violet-100 dark:bg-gray-700 w-72 h-11 rounded-[30px]" />
              <x-input-error for="password" class="mt-2" />
            </div>
          </div>
        </div>
        {{-- button save --}}
        <div class="w-full flex text-center justify-end mt-6">
          <button wire:click="save" wire:loading.attr="disabled"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-200 rounded-[15px]">Enregistrer</button>
        </div>
      </div>
    </div>
    {{-- <div class="flex items-center gap-10 rounded-[30px] p-6 bg-white dark:bg-gray-800 dark:text-gray-100">

    </div> --}}
  </div>
  <x-loading />
</div>
