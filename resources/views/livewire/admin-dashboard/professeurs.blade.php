<div class="flex flex-col gap-4 mt-8">
    {{-- Search Section --}}
    <div class="flex items-center gap-4">
        <div class="flex items-center relative">
            <svg class="absolute top-3 left-3" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.95349 16.5194C10.738 16.519 12.471 15.9217 13.8767 14.8224L18.2963 19.2418L19.7178 17.8203L15.2983 13.4009C16.3981 11.9952 16.9959 10.2618 16.9963 8.47698C16.9963 4.0426 13.3881 0.43457 8.95349 0.43457C4.51886 0.43457 0.910645 4.0426 0.910645 8.47698C0.910645 12.9114 4.51886 16.5194 8.95349 16.5194ZM8.95349 2.44517C12.2802 2.44517 14.9856 5.15044 14.9856 8.47698C14.9856 11.8035 12.2802 14.5088 8.95349 14.5088C5.62677 14.5088 2.92136 11.8035 2.92136 8.47698C2.92136 5.15044 5.62677 2.44517 8.95349 2.44517Z"
                    fill="#959595" />
            </svg>
            <input class="h-[44px] w-[303px] px-10 outline-none rounded-[30px] border-none text-sm" type="serach"
                placeholder="Rechercher">
        </div>


        <div class="flex items-center gap-1">
            <select class="h-[34px] rounded-[30px] outline-none border-none text-sm pl-4" name="departement">
                <option class="text-[#707FDD]" value="">Tout les départements</option>
                @foreach ($departements as $departement)
                    <option value="{{ $departement->name }}">{{ $departement->name }}</option>
                @endforeach
            </select>

            <select class="h-[34px] rounded-[30px] outline-none border-none text-sm pl-4" name="filiere">
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
    <hr class="mb-4 w-200px h-px bg-[#E5E5E5]" />
    <table class="w-full border-separate border-spacing-y-2 text-center text-sm">
        <thead class="text-[#ACACAC] text-sm font-semibold">
            <tr>
                <th>pic</th>
                <th>Nom</th>
                <th>CIN</th>
                <th>Email</th>
                <th>Déparement</th>
                <th>Filière</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($professeurs as $professeur)
                <tr class="h-20 bg-white">
                    <td class="rounded-l-[30px]"></td>
                    <td class="">{{ $professeur->name }}</td>
                    <td class="">{{ $teachers->where('user_id', $professeur->id)->first()->CIN }}</td>
                    <td class="">{{ $professeur->email }}</td>
                    <td></td>
                    {{-- <td class="">{{ $departements->where('id', $filieres->id)->where('major_id', $modules->id)->where('module_id', $teacher->id)->first()->name }}</td> --}}
                    <td class=""></td>
                    <td class="rounded-r-[30px]"></td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
