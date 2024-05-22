import 'flowbite';
import "./bootstrap";
import Chart from "chart.js/auto";
import '../../vendor/masmerise/livewire-toaster/resources/js'; 

window.Chart = Chart;

// ----------- Theme Toggle ---------------------
window.themeSwitcher = function () {
    return {
        switchOn: JSON.parse(localStorage.getItem("isDark")) || false,
        switchTheme() {
            if (this.switchOn) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
            localStorage.setItem("isDark", this.switchOn);
        },
    };
};


document.addEventListener("DOMContentLoaded", () => {

    Livewire.hook('message.processed', (component) => {
        setTimeout(function() {
            $('#toast-success').fadeOut('fast');
        }, 300);
    });

});
