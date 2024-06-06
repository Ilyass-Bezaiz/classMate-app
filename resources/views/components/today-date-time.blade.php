@php
    use Carbon\Carbon;
    Carbon::setLocale('fr');
    $currentDate = Carbon::now()->addHour();
    $formattedDate = $currentDate->isoFormat('dddd DD MMMM YYYY');
    $formattedTime = $currentDate->isoFormat('HH:mm:ss');
@endphp

<p  wire:poll.600ms class="poppins-semibold text-gray-900 dark:text-white ">
    {{ $formattedDate }} <span class="primary-color mx-2">|</span> {{ $formattedTime }}
</p>
