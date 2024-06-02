<div x-cloak x-data="window.themeSwitcher()" x-init="switchTheme()" @keydown.window.tab="switchOn = false"
    class="flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-full w-8 h-8 cursor-pointer shadow-sm ">
    <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

    <svg  x-transition x-show="!switchOn" @click="switchOn = true; switchTheme()"
        class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg"
        style="fill: currentColor;overflow: hidden;"
        viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M524.8 938.666667h-4.266667a439.893333 439.893333 0 0 1-313.173333-134.4 446.293333 446.293333 0 0 1-11.093333-597.333334 432.213333 432.213333 0 0 1 170.666666-116.906666 42.666667 42.666667 0 0 1 45.226667 9.386666 42.666667 42.666667 0 0 1 10.24 42.666667 358.4 358.4 0 0 0 82.773333 375.893333 361.386667 361.386667 0 0 0 376.746667 82.773334 42.666667 42.666667 0 0 1 54.186667 55.04A433.493333 433.493333 0 0 1 836.266667 810.666667a438.613333 438.613333 0 0 1-311.466667 128z" />
    </svg>

    <svg  x-transition x-show="switchOn" @click="switchOn = false; switchTheme()" class="w-5 h-5 text-yellow-300"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
        viewBox="0 0 256 256" xml:space="preserve">
        <g style="stroke: none; stroke-width: 0; fill: currentColor; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill-rule: nonzero; opacity: 1;"
            transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
            <path
                d="M 88 47 H 77.866 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 H 88 c 1.104 0 2 0.896 2 2 S 89.104 47 88 47 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 12.134 47 H 2 c -1.104 0 -2 -0.896 -2 -2 s 0.896 -2 2 -2 h 10.134 c 1.104 0 2 0.896 2 2 S 13.239 47 12.134 47 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 45 14.134 c -1.104 0 -2 -0.896 -2 -2 V 2 c 0 -1.104 0.896 -2 2 -2 s 2 0.896 2 2 v 10.134 C 47 13.239 46.104 14.134 45 14.134 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 45 90 c -1.104 0 -2 -0.896 -2 -2 V 77.866 c 0 -1.104 0.896 -2 2 -2 s 2 0.896 2 2 V 88 C 47 89.104 46.104 90 45 90 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 75.405 77.405 c -0.512 0 -1.023 -0.195 -1.414 -0.586 l -7.166 -7.166 c -0.781 -0.781 -0.781 -2.047 0 -2.828 s 2.047 -0.781 2.828 0 l 7.166 7.166 c 0.781 0.781 0.781 2.047 0 2.828 C 76.429 77.21 75.917 77.405 75.405 77.405 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 21.76 23.76 c -0.512 0 -1.024 -0.195 -1.414 -0.586 l -7.166 -7.166 c -0.781 -0.781 -0.781 -2.047 0 -2.828 c 0.78 -0.781 2.048 -0.781 2.828 0 l 7.166 7.166 c 0.781 0.781 0.781 2.047 0 2.828 C 22.784 23.565 22.272 23.76 21.76 23.76 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 68.239 23.76 c -0.512 0 -1.023 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 l 7.166 -7.166 c 0.781 -0.781 2.047 -0.781 2.828 0 c 0.781 0.781 0.781 2.047 0 2.828 l -7.166 7.166 C 69.263 23.565 68.751 23.76 68.239 23.76 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 14.594 77.405 c -0.512 0 -1.024 -0.195 -1.414 -0.586 c -0.781 -0.781 -0.781 -2.047 0 -2.828 l 7.166 -7.166 c 0.78 -0.781 2.048 -0.781 2.828 0 c 0.781 0.781 0.781 2.047 0 2.828 l -7.166 7.166 C 15.618 77.21 15.106 77.405 14.594 77.405 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
            <path
                d="M 45 66.035 c -11.599 0 -21.035 -9.437 -21.035 -21.035 S 33.401 23.965 45 23.965 S 66.035 33.401 66.035 45 S 56.599 66.035 45 66.035 z"
                style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: currentColor; fill-rule: nonzero; opacity: 1;"
                transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
        </g>
    </svg>

</div>

