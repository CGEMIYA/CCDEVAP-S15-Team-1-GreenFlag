const params = new URLSearchParams(window.location.search);
const id = params.get("id") || window.currentSpotId || 1;

// Temporary bridge for the original 6 spots while waiting for database image overhaul
const legacyGalleries = {
    1: ["photos/thumbnails/archers-place1.png", "photos/thumbnails/archers-place2.png", "photos/thumbnails/archers-place3.png", "photos/thumbnails/archers-place4.png"],
    2: ["photos/thumbnails/cafe-mesa1.png", "photos/thumbnails/cafe-mesa2.png", "photos/thumbnails/cafe-mesa3.png", "photos/thumbnails/cafe-mesa4.png"],
    3: ["photos/thumbnails/santos-garden1.png", "photos/thumbnails/santos-garden2.png", "photos/thumbnails/santos-garden3.png", "photos/thumbnails/santos-garden4.png"],
    4: ["photos/thumbnails/amphitheater1.png", "photos/thumbnails/amphitheater2.png", "photos/thumbnails/amphitheater3.png", "photos/thumbnails/amphitheater4.png"],
    5: ["photos/thumbnails/death-to-aladeen1.png", "photos/thumbnails/death-to-aladeen2.png", "photos/thumbnails/death-to-aladeen3.png", "photos/thumbnails/death-to-aladeen4.png"],
    6: ["photos/thumbnails/coffee-bean1.png", "photos/thumbnails/coffee-bean2.jpg", "photos/thumbnails/coffee-bean3.jpg", "photos/thumbnails/coffee-bean4.jpg"]
};

async function loadSpotDetail() {
    try {
        const response = await fetch(`../model/process/get_spots.php`);
        if (!response.ok) {
            throw new Error('Unable to load spot details');
        }

        const spots = await response.json();
        const spot = spots.find(item => String(item.id) === String(id)) || spots[0];

        if (!spot) {
            return;
        }

        document.getElementById("spotName").textContent = spot.name;
        document.getElementById("spotLocation").textContent = spot.location;
        
        // FIXED RATINGS: Maps avg_rating and review_count from your database query
        const avgRating = spot.avg_rating && parseFloat(spot.avg_rating) > 0 ? spot.avg_rating : 'N/A';
        const reviewCount = spot.review_count || 0;
        document.getElementById("rating").textContent = `⭐ ${avgRating} (${reviewCount} reviews)`;

        // FIXED PRICING: Converts price numbers or strings into corresponding '$' symbols
        let priceSymbols = '$$'; // default fallback
        if (spot.price) {
            const priceVal = parseInt(spot.price);
            if (!isNaN(priceVal)) {
                priceVal = Math.max(1, Math.min(priceVal, 4)); // keeps it between 1 and 4
                priceSymbols = '$'.repeat(priceVal);
            } else {
                priceSymbols = spot.price; // fallback if text like "High" was passed
            }
        }
        document.getElementById("price").textContent = priceSymbols;

        document.getElementById("description").textContent = spot.description;
        document.getElementById("hours").textContent = `🕒 ${spot.hours}`;
        document.getElementById("noise").textContent = `🔊 Noise Level: ${spot.noise}`;
        document.getElementById("privacy").textContent = `🔒 Privacy: ${spot.privacy}`;

        const mainImage = document.getElementById("mainImage");
        mainImage.src = spot.image || 'photos/aaron_profile2.jpg';

        const thumbnails = document.querySelectorAll(".thumb");
        
        // Check if the DB provided a gallery OR if it exists in the legacy bridge
        const activeGallery = spot.gallery || legacyGalleries[id];

        // If a gallery exists, populate the boxes
        if (activeGallery && activeGallery.length > 0) {
            thumbnails.forEach((thumb, index) => {
                const galleryImage = activeGallery[index];
                if (galleryImage) {
                    thumb.src = galleryImage;
                    thumb.style.display = 'block';
                    thumb.addEventListener('click', () => {
                        mainImage.src = galleryImage;
                    });
                } else {
                    thumb.style.display = 'none';
                }
            });
        } else {
            // Hide all 4 thumbnail boxes for newly created spots without a gallery
            thumbnails.forEach(thumb => thumb.style.display = 'none');
        }

        const tagContainer = document.getElementById("tags");
        tagContainer.innerHTML = '';
        (spot.tags || []).forEach(tag => {
            const tagName = tag.tag_name || tag.name || tag;
            tagContainer.innerHTML += `<span class="tag">${tagName}</span>`;
        });
    } catch (error) {
        console.error(error);
    }
}

loadSpotDetail();