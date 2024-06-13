 <div x-data="{ show: false }">
   <div x-on:click="show = ! show"
     class="relative flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full w-8 h-8 cursor-pointer shadow-sm">
     @if (!$allSeen)
       <div class="absolute top-2 left-1 bg-indigo-600 w-2 h-2 rounded-full"></div>
     @endif
     <svg class="w-5 fill-gray-600 dark:fill-slate-100" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
       <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
       <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
       <g id="SVGRepo_iconCarrier">
         <path
           d="M8.35179 20.2418C9.19288 21.311 10.5142 22 12 22C13.4858 22 14.8071 21.311 15.6482 20.2418C13.2264 20.57 10.7736 20.57 8.35179 20.2418Z">
         </path>
         <path
           d="M18.7491 9V9.7041C18.7491 10.5491 18.9903 11.3752 19.4422 12.0782L20.5496 13.8012C21.5612 15.3749 20.789 17.5139 19.0296 18.0116C14.4273 19.3134 9.57274 19.3134 4.97036 18.0116C3.21105 17.5139 2.43882 15.3749 3.45036 13.8012L4.5578 12.0782C5.00972 11.3752 5.25087 10.5491 5.25087 9.7041V9C5.25087 5.13401 8.27256 2 12 2C15.7274 2 18.7491 5.13401 18.7491 9Z">
         </path>
       </g>
     </svg>

   </div>
   <div x-cloak x-show="show" x-transition @click.away="show = false"
     class="absolute right-64 z-30 mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-md max-w-80 max-h-80 overflow-scroll ">
     <div class="flex flex-col items-center cursor-pointer">
       @forelse($notifications as $notification)
         <div
           class="flex items-center justify-between py-2 px-5 border-b {{ $notification->read ? 'bg-white dark:bg-gray-800 hover:bg-gray-100' : 'bg-slate-200 dark:bg-gray-900 hover:bg-gray-100' }} dark:border-gray-300 flex items-center gap-2  hover:dark:bg-gray-700 dark:text-white">
           <div class="w-10">
             <img class="h-8 w-8 rounded-full object-cover" src="{{ $notification->sender->user->profilePicUrl() }}"
               alt="">
           </div>
           <div class="grow text-xs text-ellipsis">
             <span
               class="font-semibold ">{{ $notification->sender->user->name }}&nbsp;</span>{{ $notification->message }}
           </div>
           <div class="w-1/12" title="Mark as read" wire:click="markAsRead({{ $notification->id }})">
             <svg class="w-6 p-1 rounded-full dark:fill-white fill-gray-600 hover:bg-gray-300 dark:hover:bg-gray-400"
               version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
               xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 442.04 442.04" xml:space="preserve"
               stroke="#707070">
               <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
               <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
               <g id="SVGRepo_iconCarrier">
                 <g>
                   <g>
                     <path
                       d="M221.02,341.304c-49.708,0-103.206-19.44-154.71-56.22C27.808,257.59,4.044,230.351,3.051,229.203 c-4.068-4.697-4.068-11.669,0-16.367c0.993-1.146,24.756-28.387,63.259-55.881c51.505-36.777,105.003-56.219,154.71-56.219 c49.708,0,103.207,19.441,154.71,56.219c38.502,27.494,62.266,54.734,63.259,55.881c4.068,4.697,4.068,11.669,0,16.367 c-0.993,1.146-24.756,28.387-63.259,55.881C324.227,321.863,270.729,341.304,221.02,341.304z M29.638,221.021 c9.61,9.799,27.747,27.03,51.694,44.071c32.83,23.361,83.714,51.212,139.688,51.212s106.859-27.851,139.688-51.212 c23.944-17.038,42.082-34.271,51.694-44.071c-9.609-9.799-27.747-27.03-51.694-44.071 c-32.829-23.362-83.714-51.212-139.688-51.212s-106.858,27.85-139.688,51.212C57.388,193.988,39.25,211.219,29.638,221.021z">
                     </path>
                   </g>
                   <g>
                     <path
                       d="M221.02,298.521c-42.734,0-77.5-34.767-77.5-77.5c0-42.733,34.766-77.5,77.5-77.5c18.794,0,36.924,6.814,51.048,19.188 c5.193,4.549,5.715,12.446,1.166,17.639c-4.549,5.193-12.447,5.714-17.639,1.166c-9.564-8.379-21.844-12.993-34.576-12.993 c-28.949,0-52.5,23.552-52.5,52.5s23.551,52.5,52.5,52.5c28.95,0,52.5-23.552,52.5-52.5c0-6.903,5.597-12.5,12.5-12.5 s12.5,5.597,12.5,12.5C298.521,263.754,263.754,298.521,221.02,298.521z">
                     </path>
                   </g>
                   <g>
                     <path
                       d="M221.02,246.021c-13.785,0-25-11.215-25-25s11.215-25,25-25c13.786,0,25,11.215,25,25S234.806,246.021,221.02,246.021z">
                     </path>
                   </g>
                 </g>
               </g>
             </svg>
             <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
             <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
             <g id="SVGRepo_iconCarrier">
               <path
                 d="M24,7l-1.7-1.7c-0.5-0.5-1.2-0.5-1.7,0L10,15.8l-4.3-4.2c-0.5-0.5-1.2-0.5-1.7,0l-1.7,1.7 c-0.5,0.5-0.5,1.2,0,1.7l5.9,5.9c0.5,0.5,1.1,0.7,1.7,0.7c0.6,0,1.2-0.2,1.7-0.7L24,8.7C24.4,8.3,24.4,7.5,24,7z">
               </path>
               <path
                 d="M48.4,18.4H27.5c-0.9,0-1.6-0.7-1.6-1.6v-3.2c0-0.9,0.7-1.6,1.6-1.6h20.9c0.9,0,1.6,0.7,1.6,1.6v3.2 C50,17.7,49.3,18.4,48.4,18.4z">
               </path>
               <path
                 d="M48.4,32.7H9.8c-0.9,0-1.6-0.7-1.6-1.6v-3.2c0-0.9,0.7-1.6,1.6-1.6h38.6c0.9,0,1.6,0.7,1.6,1.6v3.2 C50,32,49.3,32.7,48.4,32.7z">
               </path>
               <path
                 d="M48.4,47H9.8c-0.9,0-1.6-0.7-1.6-1.6v-3.2c0-0.9,0.7-1.6,1.6-1.6h38.6c0.9,0,1.6,0.7,1.6,1.6v3.2 C50,46.3,49.3,47,48.4,47z">
               </path>
             </g>
             </svg>
           </div>
         </div>
       @empty
         <div class="w-full h-full text-center text-gray-400 text-sm font-semibold p-8">
           Vous n'avez pas de notifications.
         </div>
       @endforelse
     </div>
   </div>
 </div>
