import 'flowbite';
import "./bootstrap";
import Chart from "chart.js/auto";
import '../../vendor/masmerise/livewire-toaster/resources/js';
import { animate, stagger } from "motion";


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

// ----------- bg cards animation ---------------------

document.addEventListener('livewire:navigated', () => {
    // Define the initial positions and movements
    const card1 = document.querySelector('.bg-card1');
    const card2 = document.querySelector('.bg-card2');
    const card3 = document.querySelector('.bg-card3');
    const imgCard = document.querySelector('.img-card');
    const loginCard = document.querySelector('.login-card');
    const allCards = document.querySelectorAll(".bg-card");

    // animate(allCards, { backgroundColor: "#5C6BC0" })

    animate(
        card1,
        {
            x: [-400, 0],
            rotate: 45,
        },
        {
            duration: 1,
        //   offset: [0, 0.25, 0.75]
        }
    );

    animate(
        card2,
        {
            y: [200, 0],
            rotate: 45,
        },
        {
            duration: 1,
        //   offset: [0, 0.25, 0.75]
        }
    );


    animate(
        card3,
        {
            y: [200, 0],
            x: [200, 0],
            rotate: 45,
        },
        {
            duration: 1,
        //   offset: [0, 0.25, 0.75]
        }
    );

    // animate img card
    animate(
        imgCard,
        { opacity: [0, 100] },
        {
          delay: 1,
          duration: 0.5,
          easing: [.22, .03, .26, 1]
        }
      )

    // animate login card
    animate(
        loginCard,
        { opacity: [0, 100] },
        {
          delay: 1.25,
          duration: 0.5,
          easing: [.22, .03, .26, 1]
        }
      )
});



