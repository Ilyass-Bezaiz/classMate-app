<div x-data="window.themeSwitcher()" x-init="switchTheme()" @keydown.window.tab="switchOn = false"
    class="flex items-center justify-center space-x-2 mx-4">
    <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="switchOn">

    <button x-ref="switchButton" type="button" @click="switchOn = ! switchOn; switchTheme()"
        :class="switchOn ? 'bg-blue-600' : 'bg-neutral-200'"
        class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10">
        <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'"
            class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
    </button>

    <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
        :class="{ 'text-white': switchOn, 'text-gray-900': !switchOn }" class="text-sm select-none">
        Dark Mode
    </label>
</div>
