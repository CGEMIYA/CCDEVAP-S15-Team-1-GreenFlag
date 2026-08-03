    <!-- REPLACES COPY n PASTE NAVBAR AND SIDEBAR AND ACTUALLY USES includes/header.php NOW -->
    <?php require_once __DIR__ . '/includes/header.php'; ?>

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
    <script src="js/spots.js"></script>
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/search.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/homepage.js"></script>

</body>

</html>