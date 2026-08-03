    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <!-- REPLACES COPY n PASTE NAVBAR AND SIDEBAR AND ACTUALLY USES includes/header.php NOW -->

        <main>

            <section class="spot-page">

                <div class="gallery">

                    <img id="mainImage">

                    <div class="thumbnail-row">

                        <img class="thumb">
                        <img class="thumb">
                        <img class="thumb">
                        <img class="thumb">

                    </div>

                </div>


                <div class="spot-info">

                    <h1 id="spotName"></h1>

                    <p id="spotLocation"></p>

                    <div class="rating">

                        <span id="rating"></span>

                        <span id="price"></span>

                    </div>

                    <p id="description"></p>

                    <div class="details">

                        <p id="hours"></p>

                        <p id="noise"></p>

                        <p id="privacy"></p>

                    </div>

                    <div id="tags">

                    </div>

                </div>

            </section>

            <section class="reviews">

                <div class="review-input">

                    <div class="review-left">

                        <h2>Give a Review!</h2>

                        <textarea id="reviewText" placeholder="Share your experience..."></textarea>

                        <p class="login-note">
                            🔒 Please log in to post a review.
                        </p>

                    </div>

                    <div class="post-panel">

                        <div class="flag-buttons">

                            <button class="flag green"><img src="photos/greenflag.svg" alt="Logo" ></button>

                            <button class="flag red"><img src="photos/redflag.svg" alt="Logo" ></button>

                        </div>

                        <button class="postBtn" id="postReview">
                            POST
                        </button>

                    </div>

                </div>

                <div id="reviewsContainer"></div>

            </section>

        </main>
        </div> <!-- CLOSES .page-layout -->
        <script src="js/spots.js"></script>
        <script src="js/darkmode.js"></script>
        <script src="js/sidebar.js"></script>
        <script src="js/search.js"></script>
        <script src="js/spot.js"></script>
        <script src="js/reviews.js"></script>


    </body>