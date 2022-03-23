/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Grab HTML Elements navbar
const btn = document.querySelector("#mobile-menu-button");
const menu = document.querySelector("#mobile-menu");
const btn_profile = document.querySelector("#user-menu-button");
const menu_profile = document.querySelector("#profile_menu");

// Add Event Listeners navbar
btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
});

// Add Event Listeners profile
btn_profile.addEventListener("click", () => {
    menu_profile.classList.toggle("hidden");
});