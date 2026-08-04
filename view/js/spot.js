const params = new URLSearchParams(window.location.search);
const id = params.get("id") || window.currentSpotId || 1;

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
        document.getElementById("rating").textContent = `⭐ ${spot.rating || 'N/A'} (${spot.reviews || 0})`;
        document.getElementById("price").textContent = spot.price;
        document.getElementById("description").textContent = spot.description;
        document.getElementById("hours").textContent = `🕒 ${spot.hours}`;
        document.getElementById("noise").textContent = `🔊 Noise Level: ${spot.noise}`;
        document.getElementById("privacy").textContent = `🔒 Privacy: ${spot.privacy}`;

        const mainImage = document.getElementById("mainImage");
        mainImage.src = spot.image;

        const thumbnails = document.querySelectorAll(".thumb");
        thumbnails.forEach((thumb, index) => {
            const galleryImage = spot.gallery?.[index] || spot.image;
            thumb.src = galleryImage;
            thumb.style.display = galleryImage ? 'block' : 'none';
            thumb.addEventListener('click', () => {
                mainImage.src = galleryImage;
            });
        });

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

