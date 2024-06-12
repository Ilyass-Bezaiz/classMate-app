 <div x-data="{ show: false }">
   <div x-on:click="show = ! show"
     class="relative flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full w-8 h-8 cursor-pointer shadow-sm">
     @if (!$allSeen)
       <div class="absolute top-2 left-1 bg-indigo-600 w-2 h-2 rounded-full"></div>
     @endif
     <svg class="w-5 fill-black dark:fill-slate-300" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
       xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 611.999 611.999" xml:space="preserve">
       <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
       <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
       <g id="SVGRepo_iconCarrier">
         <g>
           <g>
             <g>
               <path
                 d="M570.107,500.254c-65.037-29.371-67.511-155.441-67.559-158.622v-84.578c0-81.402-49.742-151.399-120.427-181.203 C381.969,34,347.883,0,306.001,0c-41.883,0-75.968,34.002-76.121,75.849c-70.682,29.804-120.425,99.801-120.425,181.203v84.578 c-0.046,3.181-2.522,129.251-67.561,158.622c-7.409,3.347-11.481,11.412-9.768,19.36c1.711,7.949,8.74,13.626,16.871,13.626 h164.88c3.38,18.594,12.172,35.892,25.619,49.903c17.86,18.608,41.479,28.856,66.502,28.856 c25.025,0,48.644-10.248,66.502-28.856c13.449-14.012,22.241-31.311,25.619-49.903h164.88c8.131,0,15.159-5.676,16.872-13.626 C581.586,511.664,577.516,503.6,570.107,500.254z M484.434,439.859c6.837,20.728,16.518,41.544,30.246,58.866H97.32 c13.726-17.32,23.407-38.135,30.244-58.866H484.434z M306.001,34.515c18.945,0,34.963,12.73,39.975,30.082 c-12.912-2.678-26.282-4.09-39.975-4.09s-27.063,1.411-39.975,4.09C271.039,47.246,287.057,34.515,306.001,34.515z M143.97,341.736v-84.685c0-89.343,72.686-162.029,162.031-162.029s162.031,72.686,162.031,162.029v84.826 c0.023,2.596,0.427,29.879,7.303,63.465H136.663C143.543,371.724,143.949,344.393,143.97,341.736z M306.001,577.485 c-26.341,0-49.33-18.992-56.709-44.246h113.416C355.329,558.493,332.344,577.485,306.001,577.485z">
               </path>
               <path
                 d="M306.001,119.235c-74.25,0-134.657,60.405-134.657,134.654c0,9.531,7.727,17.258,17.258,17.258 c9.531,0,17.258-7.727,17.258-17.258c0-55.217,44.923-100.139,100.142-100.139c9.531,0,17.258-7.727,17.258-17.258 C323.259,126.96,315.532,119.235,306.001,119.235z">
               </path>
             </g>
           </g>
         </g>
       </g>
     </svg>
   </div>
   <div x-cloak x-show="show" x-transition @click.away="show = false"
     class="absolute right-3 z-30 mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-md max-w-80 max-h-80 overflow-scroll ">
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
             <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"
               enable-background="new 0 0 52 52" xml:space="preserve">
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
