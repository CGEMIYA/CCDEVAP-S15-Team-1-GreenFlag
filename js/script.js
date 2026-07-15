/*

const toggle = document.getElementById("themeToggle");

toggle.addEventListener("click", () => {

    document.body.classList.toggle("dark");

    const icon = toggle.querySelector("i");

    if (document.body.classList.contains("dark")) {

        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");

    } else {

        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");

    }

});
*/

let currentPage = 0;

let cardsPerPage = getCardsPerPage();

function getCardsPerPage() {

    if (window.innerWidth <= 768) {

        return 1;

    }

    if (window.innerWidth <= 992) {

        return 2;

    }

    return 3;

}

window.addEventListener("resize", () => {

    cardsPerPage = getCardsPerPage();

    currentPage = 0;

    displayCards();

});

const container = document.getElementById("cardsContainer");

function displayCards() {

    container.innerHTML = "";

    const start = currentPage * cardsPerPage;

    const end = start + cardsPerPage;

    const currentCards = spots.slice(start, end);

    currentCards.forEach(spot => {

        container.innerHTML += `

<div class="card"
     onclick="openSpot(${spots.indexOf(spot)})">

    <img src="${spot.image}" alt="${spot.name}">

    <div class="card-content">

        <h3>${spot.name}</h3>

        <p class="location">
            📍 ${spot.location}
        </p>

        <p>
            ${spot.tags.join(" • ")}
        </p>

        <div class="info">

            <span>
                ⭐ ${spot.rating} (${spot.reviews})
            </span>

            <span>
                ${spot.price}
            </span>

        </div>

        <div class="card-footer">

        <span class="view-spot">
            View Spot →
        </span>

    </div>

</div>

`;

    });

}

displayCards();

document.getElementById("nextBtn").onclick = () => {

    if ((currentPage + 1) * cardsPerPage < spots.length) {

        currentPage++;

        displayCards();

    }

}

document.getElementById("prevBtn").onclick = () => {

    if (currentPage > 0) {

        currentPage--;

        displayCards();

    }

}

const searchInput = document.getElementById("searchInput");
const searchResults = document.getElementById("searchResults");

searchInput.addEventListener("input", function () {

    const query = this.value.trim().toLowerCase();

    searchResults.innerHTML = "";

    if (query === "") {

        searchResults.style.display = "none";
        return;

    }

    const matches = spots.filter(spot =>

        spot.name.toLowerCase().includes(query) ||

        spot.location.toLowerCase().includes(query) ||

        spot.tags.some(tag =>
            tag.toLowerCase().includes(query)
        )

    );

    if (matches.length === 0) {

        searchResults.innerHTML = `
            <div class="search-item">
                No results found.
            </div>
        `;

    } else {

        matches.forEach(spot => {

            searchResults.innerHTML += `

            <div class="search-item"
                onclick="location.href='spot.php?id=${spots.indexOf(spot)}'">

                <strong>${spot.name}</strong><br>

                <small>${spot.location}</small>

            </div>

            `;

        });

    }

    searchResults.style.display = "block";

});

// original onclick="showSpot('${spot.name}')"

// for now, until the display page is coded
function showSpot(name) {

    const index = spots.findIndex(spot => spot.name === name);

    currentPage = Math.floor(index / cardsPerPage);

    displayCards();

    searchResults.style.display = "none";

    searchInput.value = "";

}

document.addEventListener("click", function (e) {

    if (!searchInput.contains(e.target) &&
        !searchResults.contains(e.target)) {

        searchResults.style.display = "none";

    }

});

searchInput.addEventListener("keydown", function (e) {

    if (e.key === "Enter") {

        const first = spots.find(spot =>

            spot.name.toLowerCase().includes(this.value.toLowerCase())

        );

        if (first) {

            showSpot(first.name);

        }

    }

});

function openSpot(id) {

    window.location.href = `spot.php?id=${id}`;

}