const params = new URLSearchParams(window.location.search);

const id = params.get("id");

const spot = spots[id];

document.getElementById("spotName").textContent =
    spot.name;

document.getElementById("spotLocation").textContent =
    spot.location;

document.getElementById("rating").textContent =
    `⭐ ${spot.rating} (${spot.reviews})`;

document.getElementById("price").textContent =
    spot.price;

document.getElementById("description").textContent =
    spot.description;

document.getElementById("hours").textContent =
    `🕒 ${spot.hours}`;

document.getElementById("noise").textContent =
    `🔊 Noise Level: ${spot.noise}`;

document.getElementById("privacy").textContent =
    `🔒 Privacy: ${spot.privacy}`;

//document.getElementById("mainImage").src =
//spot.image;

const mainImage = document.getElementById("mainImage");

// Use the first gallery image if available,
// otherwise fall back to the thumbnail image.
mainImage.src = spot.gallery?.[0] || spot.image;

const thumbnails = document.querySelectorAll(".thumb");

thumbnails.forEach((thumb, index) => {

    if (spot.gallery && spot.gallery[index]) {

        thumb.src = spot.gallery[index];

        thumb.style.display = "block";

        thumb.addEventListener("click", () => {

            mainImage.src = spot.gallery[index];

        });

    } else {

        thumb.style.display = "none";

    }

});

const tagContainer = document.getElementById("tags");

spot.tags.forEach(tag => {

    tagContainer.innerHTML += `

<span class="tag">

${tag}

</span>

`;

});

const reviewContainer =
    document.getElementById("reviewsContainer");

spot.comments.forEach(comment => {

    reviewContainer.innerHTML += `

<div class="review">

<h4>${comment.user}</h4>

<p>${"⭐".repeat(comment.rating)}</p>

<p>${comment.text}</p>

</div>

`;

});

