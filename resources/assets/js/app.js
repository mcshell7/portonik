// Theme by default loads a jQuery as dependency of the main script.
// Let's include it using ES6 modules import.


import 'slick-carousel/slick/slick';

import './_sliders';
import './_nav';


var navItem = document.querySelectorAll(".menu__list-item");
console.log(navItem);
// navItem.parentElement.style.color = "red";

