/* ============================================
   GREEN FLAG
   SEARCH BAR
============================================ */

const searchContainer = document.querySelector(".search-container");
const searchInput = document.getElementById("searchInput");
const searchResults = document.getElementById("searchResults");

/* ===========================
   SEARCH
=========================== */

if (searchInput && searchResults) {
    searchInput.addEventListener("input", () => {
        const query = searchInput.value.trim().toLowerCase();
        searchResults.innerHTML = "";

        if (query === "") {
            searchResults.style.display = "none";
            return;
        }

        const matches = (spots || []).filter(spot =>
            (spot.name || '').toLowerCase().includes(query) ||
            (spot.location || '').toLowerCase().includes(query) ||
            (spot.tags || []).some(tag =>
                (tag.tag_name || tag.name || tag).toLowerCase().includes(query)
            )
        );

        if (matches.length === 0) {
            searchResults.innerHTML = `
                <div class="search-item">
                    No results found.
                </div>
            `;
        } else {
            matches.forEach((spot) => {
                // FIX: Use real Database ID instead of array index
                const dbId = spot.id; 

                searchResults.innerHTML += `
                    <div class="search-item" onclick="goToSpot(${dbId})">
                        <strong>${spot.name}</strong><br>
                        <small>📍 ${spot.location}</small>
                    </div>
                `;
            });
        }
        searchResults.style.display = "block";
    });
}

/* ===========================
   GO TO SPOT
=========================== */

function goToSpot(id) {
    window.location.href = `spot.php?id=${id}`;
}

/* ===========================
   ENTER KEY
=========================== */

if (searchInput) {
    searchInput.addEventListener("keydown", (event) => {
        if (event.key !== "Enter") return;

        const query = searchInput.value.trim().toLowerCase();
        const match = (spots || []).find(spot =>
            (spot.name || '').toLowerCase().includes(query) ||
            (spot.location || '').toLowerCase().includes(query) ||
            (spot.tags || []).some(tag =>
                (tag.tag_name || tag.name || tag).toLowerCase().includes(query)
            )
        );

        if (match) {
            // FIX: Use real Database ID instead of array index
            goToSpot(match.id);
        }
    });
}

/* ===========================
   CLICK OUTSIDE
=========================== */

document.addEventListener("click", (event) => {
    if (searchContainer && !searchContainer.contains(event.target)) {
        searchResults.style.display = "none";
    }
});

if (searchInput) {
    searchInput.addEventListener("focus", () => {
        if (searchResults.innerHTML !== "") {
            searchResults.style.display = "block";
        }
    });
}

/* ===========================
   INITIALIZE DATABASE FETCH
=========================== */
// FIX: Force the search bar to load the database spots if the carousel didn't already do it
if (typeof loadSpots === 'function') {
    // Only fetch if spots array is empty so we don't spam the server
    if (!spots || spots.length === 0) {
        loadSpots();
    }
}