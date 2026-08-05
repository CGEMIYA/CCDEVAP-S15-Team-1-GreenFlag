/* ============================================
   GREEN FLAG - REVIEWS DATABASE BRIDGE
============================================ */
const postButton = document.getElementById("postReview");
const reviewText = document.getElementById("reviewText");

const greenFlagBtn = document.querySelector(".flag.green");
const redFlagBtn = document.querySelector(".flag.red");

let selectedRating = 0; // Default state

// Handle Flag Selection (Green = Good, Red = Bad)
if (greenFlagBtn && redFlagBtn) {
    greenFlagBtn.addEventListener("click", (e) => {
        e.preventDefault();
        selectedRating = 5;
        
        // Visual indicator it is selected
        greenFlagBtn.style.border = "3px solid #28a745";
        greenFlagBtn.style.borderRadius = "8px";
        greenFlagBtn.style.backgroundColor = "#e8f5e9";
        
        // Reset red flag
        redFlagBtn.style.border = "none";
        redFlagBtn.style.backgroundColor = "transparent";
    });
    
    redFlagBtn.addEventListener("click", (e) => {
        e.preventDefault();
        selectedRating = 1;
        
        // Visual indicator it is selected
        redFlagBtn.style.border = "3px solid #dc3545";
        redFlagBtn.style.borderRadius = "8px";
        redFlagBtn.style.backgroundColor = "#ffebee";
        
        // Reset green flag
        greenFlagBtn.style.border = "none";
        greenFlagBtn.style.backgroundColor = "transparent";
    });
}

// Handle Submit Button
if (postButton && reviewText) {
    postButton.addEventListener("click", async (event) => {
        event.preventDefault();

        // Use the safe window variable
        if (!window.userIsLoggedIn) {
            alert("You must be signed in before posting a review.\n\nPlease login or create an account first.");
            return;
        }

        const text = reviewText.value.trim();

        if (text === "") {
            alert("Please write a review before posting!");
            return;
        }

        if (selectedRating === 0) {
            alert("Please select a Green Flag or Red Flag rating!");
            return;
        }

        // Disable button while processing to prevent double-clicks
        postButton.disabled = true;
        postButton.innerText = "POSTING...";

        // Send the data to PHP
        try {
            const response = await fetch("../controller/reviews/add.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    spot_id: window.dbSpotId,
                    rating: selectedRating,
                    review: text
                })
            });

            const result = await response.json();

            if (result.success) {
                notifySuccess(result.message || "Review submitted successfully.");

                const flagDisplay = selectedRating === 5 ? "🟩 Green Flag" : "🟥 Red Flag";

                // Build the HTML for new review dynamically
                const newReviewHTML = `
                    <div class="review" style="animation: fadeIn 0.5s;">
                        <h4>${window.userFullName}</h4>
                        <p><b>${flagDisplay}</b></p>
                        <p>${text.replace(/\n/g, '<br>')}</p>
                        <small style="color: #888; font-size: 0.8rem;">Just now</small>
                    </div>
                `;

                // Inject it into page instantly
                const container = document.getElementById("reviewsContainer");
                if (container) {
                    // If the "No reviews yet" message is there, clear it out first
                    if (container.innerHTML.includes("No reviews yet")) {
                        container.innerHTML = "";
                    }
                    // Insert the new review at the very top of the list!
                    container.insertAdjacentHTML('afterbegin', newReviewHTML);
                }

                // Clean up the form
                reviewText.value = ""; 
                selectedRating = 0;
                greenFlagBtn.style.border = "none";
                greenFlagBtn.style.backgroundColor = "transparent";
                redFlagBtn.style.border = "none";
                redFlagBtn.style.backgroundColor = "transparent";
            } else {
                notifyError(result.message || result.error || "Unable to submit review. Please try again.");
            }
        } catch (error) {
            console.error("Error submitting review:", error);
            notifyError("A network error occurred. Please try again.");
        } finally {
            // Re-enable the button
            postButton.disabled = false;
            postButton.innerText = "POST";
        }
    });
}