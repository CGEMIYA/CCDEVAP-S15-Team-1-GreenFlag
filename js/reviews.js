/* ============================================
   GREEN FLAG
   REVIEWS
============================================ */

// Temporary until backend is finished
const isLoggedIn = false;

const postButton =
document.getElementById("postReview");

const reviewText =
document.getElementById("reviewText");

if(postButton){

    postButton.addEventListener("click",(event)=>{

        event.preventDefault();

        if(!isLoggedIn){

            alert(
`You must be signed in before posting a review.

Please login or create an account first.`
            );

            return;

        }

        // Later this will submit to PHP

        alert("Review submitted!");

    });

}
