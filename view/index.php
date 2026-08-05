    <?php require_once __DIR__ . '/includes/header.php'; ?>
    <!-- REPLACES COPY n PASTE NAVBAR AND SIDEBAR AND ACTUALLY USES includes/header.php NOW -->

    <main>

        <section class="popular">

            <div class="section-header">
                <h2>Popular Now</h2>
                <a href="viewAll.php">View All</a>
            </div>

            <div class="carousel">

                <button class="arrow" id="prevBtn">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="cards-container" id="cardsContainer">

                </div>

                <button class="arrow" id="nextBtn">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

            </div>

        </section>

    </main>
    </div> <!-- CLOSES .page-layout -->
    <script src="js/spots.js?v=<?php echo time(); ?>"></script>
    <script src="js/darkmode.js?v=<?php echo time(); ?>"></script>
    <script src="js/sidebar.js?v=<?php echo time(); ?>"></script>
    <script src="js/search.js?v=<?php echo time(); ?>"></script>
    <script src="js/carousel.js?v=<?php echo time(); ?>"></script> <!-- Cache Buster added! -->
    <script src="js/homepage.js?v=<?php echo time(); ?>"></script>

</body>

</html>