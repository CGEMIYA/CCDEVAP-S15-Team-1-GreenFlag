let spots = [];

async function loadSpots() {
    try {
        const response = await fetch('../model/process/get_spots.php');
        if (!response.ok) {
            throw new Error('Unable to load spots');
        }

        const data = await response.json();
        spots = data.map(spot => ({
            ...spot,
            tags: Array.isArray(spot.tags) ? spot.tags.map(tag => tag.tag_name || tag.name || tag) : []
        }));
        displayCards();
        if (typeof renderSearchResults === 'function') {
            renderSearchResults();
        }
    } catch (error) {
        console.error(error);
    }
}

function renderSearchResults() {
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    if (!searchInput || !searchResults) {
        return;
    }

    const query = searchInput.value.trim().toLowerCase();
    searchResults.innerHTML = '';

    if (query === '') {
        searchResults.style.display = 'none';
        return;
    }

    const matches = spots.filter(spot =>
        (spot.name || '').toLowerCase().includes(query) ||
        (spot.location || '').toLowerCase().includes(query) ||
        (spot.tags || []).some(tag =>
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
                    onclick="location.href='spot.php?id=${spot.id}'">
                    <strong>${spot.name}</strong><br>
                    <small>${spot.location}</small>
                </div>
            `;
        });
    }

    searchResults.style.display = 'block';
}

