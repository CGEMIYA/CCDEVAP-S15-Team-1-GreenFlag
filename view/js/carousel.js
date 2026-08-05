/* ============================================
   GREEN FLAG
   HOMEPAGE CAROUSEL
============================================ */

const cardsContainer = document.getElementById("cardsContainer");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

let currentPage = 0;
let cardsPerPage = getCardsPerPage();

/* ===========================
   RESPONSIVE CARD COUNT
=========================== */

function getCardsPerPage() {
    if (window.innerWidth <= 768) {
        return 1;
    }
    if (window.innerWidth <= 992) {
        return 2;
    }
    return 3;
}

/* ===========================
   DISPLAY CARDS
=========================== */

function displayCards() {
    if (!cardsContainer) return;
    cardsContainer.innerHTML = "";

    const start = currentPage * cardsPerPage;
    const end = start + cardsPerPage;
    const visibleSpots = (spots || []).slice(start, end);

    visibleSpots.forEach((spot) => {
        const dbId = spot.id; 
        const rating = spot.avg_rating || spot.rating || 'N/A';
        const reviews = spot.review_count || spot.reviews || 0;

        const tagsHtml = (spot.tags && spot.tags.length > 0) 
            ? spot.tags.join(" • ") 
            : "No Tags";

        // ADDED: The price map dictionary and .trim() safety check
        const priceMap = { 'Free': 'Free', 'Low': '$', 'Medium': '$$', 'High': '$$$' };
        const rawPrice = spot.price ? spot.price.trim() : '';
        const displayPrice = priceMap[rawPrice] || rawPrice || '$$';

        // ADDED: Checks if the image is empty OR if the database accidentally saved the placeholder text
        const isPlaceholder = spot.image && (spot.image.includes('aaron') || spot.image.includes('placeholder'));
        const imgHtml = (spot.image && !isPlaceholder) ? `<img src="${spot.image}" alt="${spot.name}">` : '';

        cardsContainer.innerHTML += `
        <div class="card" onclick="openSpot(${dbId})">
            ${imgHtml}
            <div class="card-content">
                <h3>${spot.name}</h3>
                <p class="location">📍 ${spot.location}</p>
                <p>${tagsHtml}</p>
                <div class="info">
                    <span>⭐ ${rating} (${reviews})</span>
                    <span>${displayPrice}</span>
                </div>
                <div class="card-footer">
                    <span class="view-spot">View Spot →</span>
                </div>
            </div>
        </div>
        `;
    });

    updateButtons();
}

/* ===========================
   BUTTON STATES
=========================== */

function updateButtons() {
    if (!prevBtn || !nextBtn) return;
    prevBtn.disabled = currentPage === 0;
    nextBtn.disabled = (currentPage + 1) * cardsPerPage >= (spots || []).length;
}

/* ===========================
   OPEN SPOT
=========================== */

function openSpot(id) {
    window.location.href = `spot.php?id=${id}`;
}

/* ===========================
   PREVIOUS / NEXT BUTTONS
=========================== */

if (prevBtn) {
    prevBtn.addEventListener("click", () => {
        if (currentPage > 0) {
            currentPage--;
            displayCards();
        }
    });
}

if (nextBtn) {
    nextBtn.addEventListener("click", () => {
        if ((currentPage + 1) * cardsPerPage < (spots || []).length) {
            currentPage++;
            displayCards();
        }
    });
}

/* ===========================
   WINDOW RESIZE
=========================== */

window.addEventListener("resize", () => {
    cardsPerPage = getCardsPerPage();
    currentPage = 0;
    displayCards();
});

/* ===========================
   INITIALIZE
=========================== */

if (typeof loadSpots === 'function') {
    loadSpots();
} else {
    displayCards();
}