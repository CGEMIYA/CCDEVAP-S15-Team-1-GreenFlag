/* ============================================
   GREEN FLAG
   DARK MODE
============================================ */

const themeToggle = document.getElementById("themeToggle");

// Restore previously selected theme
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");

    if (themeToggle) {
        themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i>';
    }
}

// Toggle theme
if (themeToggle) {

    themeToggle.addEventListener("click", () => {

        document.body.classList.toggle("dark");

        const darkModeEnabled = document.body.classList.contains("dark");

        if (darkModeEnabled) {

            localStorage.setItem("theme", "dark");

            themeToggle.innerHTML =
                '<i class="fa-solid fa-sun"></i>';

        } else {

            localStorage.setItem("theme", "light");

            themeToggle.innerHTML =
                '<i class="fa-solid fa-moon"></i>';

        }

    });

}