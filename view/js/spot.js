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

        // FIXED PRICING: Includes .trim() to prevent invisible spaces from breaking the map
        const priceMap = {
            'Free': 'Free',
            'Low': '$',
            'Medium': '$$',
            'High': '$$$'
        };
        const rawPrice = spot.price ? spot.price.trim() : '';
        document.getElementById("price").textContent = priceMap[rawPrice] || rawPrice || '$$';

        document.getElementById("description").textContent = spot.description;
        document.getElementById("hours").textContent = `🕒 ${spot.hours}`;
        document.getElementById("noise").textContent = `🔊 Noise Level: ${spot.noise}`;
        document.getElementById("privacy").textContent = `🔒 Privacy: ${spot.privacy}`;

        const galleryContainer = document.querySelector(".gallery");
        const mainImage = document.getElementById("mainImage");
        const thumbnails = document.querySelectorAll(".thumb");
        
        const activeGallery = spot.gallery || legacyGalleries[id];

        // STRICT IMAGE CHECK: Treats 'aaron' or 'placeholder' database strings as NO IMAGE
        const isPlaceholder = spot.image && (spot.image.includes('aaron') || spot.image.includes('placeholder'));
        const hasValidImage = spot.image && !isPlaceholder;
            
        //NO IMAGE
        // If there is NO valid image AND NO gallery, completely hide the left side
        if (!hasValidImage && (!activeGallery || activeGallery.length === 0)) {
            galleryContainer.style.display = 'block';//used to be none, but changed to block to show the gallery container even if no images are available
        } else {
            galleryContainer.style.display = 'block';
            
            // Apply the valid image, or fallback to the gallery array
            mainImage.src = hasValidImage ? spot.image : (activeGallery ? activeGallery[0] : '');

            // Populate thumbnails
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
                thumbnails.forEach(thumb => thumb.style.display = 'none');
            }
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