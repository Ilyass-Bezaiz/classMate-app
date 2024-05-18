<div class="flex flex-col gap-4 pt-8 pb-24 px-8 h-screen overflow-y-auto">
    {{-- Search Section --}}
    <div class="flex items-center gap-4">
        <div class="flex items-center relative">
            <svg class="absolute top-3 left-3" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.95349 16.5194C10.738 16.519 12.471 15.9217 13.8767 14.8224L18.2963 19.2418L19.7178 17.8203L15.2983 13.4009C16.3981 11.9952 16.9959 10.2618 16.9963 8.47698C16.9963 4.0426 13.3881 0.43457 8.95349 0.43457C4.51886 0.43457 0.910645 4.0426 0.910645 8.47698C0.910645 12.9114 4.51886 16.5194 8.95349 16.5194ZM8.95349 2.44517C12.2802 2.44517 14.9856 5.15044 14.9856 8.47698C14.9856 11.8035 12.2802 14.5088 8.95349 14.5088C5.62677 14.5088 2.92136 11.8035 2.92136 8.47698C2.92136 5.15044 5.62677 2.44517 8.95349 2.44517Z"
                    fill="#959595" />
            </svg>
            <input wire:model.live='search'
                class="h-[44px] w-[303px] px-10 outline-none rounded-[30px] border-none text-sm dark:bg-gray-800 dark:text-gray-100"
                type="serach" placeholder="Rechercher">
        </div>


        <div class="flex items-center gap-1">
            <select wire:model.live='filter_dep'
                class="h-[34px] rounded-[30px] outline-none border-none text-sm pl-4 dark:bg-gray-800 dark:text-gray-100"
                name="departement">
                <option class="text-[#707FDD]" value="">Tout les départements</option>
                @foreach ($departements as $departement)
                    <option value="{{ $departement->name }}">{{ $departement->name }}</option>
                @endforeach
            </select>

            <select
                class="h-[34px] rounded-[30px] outline-none border-none text-sm pl-4 dark:bg-gray-800 dark:text-gray-100"
                name="filiere">
                <option class="text-[#707FDD]" value="">Tout les filièré</option>
                @foreach ($filieres as $filiere)
                    <option value="{{ $filiere->name }}">{{ $filiere->name }}</option>
                @endforeach
            </select>

        </div>



        <div class="w-full flex justify-end">
            <button class="h-[44px] px-6 bg-[#707FDD] rounded-[30px] text-white text-sm font-semibold">Ajouter un
                Professeur</button>
        </div>
    </div>
    <hr class="mb-4 w-200px border-none h-px bg-gray-200 dark:bg-gray-800" />
    <table class="w-full border-separate border-spacing-y-2 text-center text-sm dark:text-gray-100">
        <thead class="text-[#ACACAC] text-sm font-semibold">
            <tr>
                <th></th>
                <th>Nom</th>
                <th>CIN</th>
                <th>Email</th>
                <th>Déparement</th>
                <th>Filière</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professeurs as $professeur)
                <tr class="h-20 bg-white dark:bg-gray-800">
                    <td class="rounded-l-[30px] w-24">
                        <img height="52" width="52" class="rounded-full shadow-md shadow-black ml-6"
                            src="{{ Auth::user()->profile_photo_url }}">
                    </td>
                    <td class="">{{ $professeur->name }}</td>
                    <td class="">{{ $professeur->getTeacherByUserId($professeur->id)->CIN }}</td>
                    <td class="">{{ $professeur->email }}</td>
                    <td class="">{{ $professeur->getDepartementByTeacherId($professeur->id)->name }}</td>
                    <td class="">{{ $professeur->getMajorByTeacherId($professeur->id)->name }}</td>
                    <td class="w-16 rounded-r-[30px] text-end fill-none ">
                        <a wire:navigate href="{{ route('professeur.profile', $professeur->id) }}">
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
                                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                        <feOffset dy="2" />
                                        <feGaussianBlur stdDeviation="0.5" />
                                        <feColorMatrix type="matrix"
                                            values="0 0 0 0 0.25098 0 0 0 0 0.282353 0 0 0 0 0.321569 0 0 0 0.05 0" />
                                        <feBlend mode="normal" in2="BackgroundImageFix"
                                            result="effect1_dropShadow_29_1282" />
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_29_1282"
                                            result="shape" />
                                    </filter>
                                </defs>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div>
        {{ $professeurs->links() }}
    </div>
</div>
