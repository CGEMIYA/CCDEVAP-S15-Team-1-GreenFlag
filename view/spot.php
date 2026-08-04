    <?php 
        require_once __DIR__ . '/includes/header.php'; 
        require_once __DIR__ . '/../model/config/database.php';

        $spotId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

        // Removed the status check for reviews
        $stmt = $pdo->prepare("SELECT r.rating, r.review, r.created_at, u.full_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.spot_id = :spot_id
            ORDER BY r.created_at DESC");
        $stmt->execute([':spot_id' => $spotId]);
        $dbReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $spotStmt = $pdo->prepare("SELECT s.*, t.id AS tag_id, t.tag_name FROM spots s LEFT JOIN spot_tags st ON st.spot_id = s.id LEFT JOIN tags t ON t.id = st.tag_id WHERE s.id = :spot_id ORDER BY t.tag_name ASC");
        $spotStmt->execute([':spot_id' => $spotId]);
        $spotRows = $spotStmt->fetchAll(PDO::FETCH_ASSOC);
        $spotData = $spotRows ? $spotRows[0] : null;
        $spotTags = [];
        if ($spotRows) {
            foreach ($spotRows as $row) {
                if (!empty($row['tag_id'])) {
                    $spotTags[] = ['id' => (int) $row['tag_id'], 'tag_name' => $row['tag_name']];
                }
            }
        }
    ?>
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
                        
                        <!-- Check if user is logged in -->
                        <?php if (isset($_SESSION["user_id"])): ?>
                            <textarea id="reviewText" placeholder="Share your experience..."></textarea>
                        <?php else: ?>
                            <textarea id="reviewText" placeholder="You must be logged in to type here..." disabled style="background-color: #f0f0f0; cursor: not-allowed;"></textarea>
                            <p class="login-note">🔒 Please log in to post a review.</p>
                        <?php endif; ?>
                    </div>

                    <div class="post-panel">
                        <div class="flag-buttons">
                            <!-- Added type="button" so they don't accidentally act like submit buttons -->
                            <button type="button" class="flag green"><img src="photos/greenflag.svg" alt="Logo"></button>
                            <button type="button" class="flag red"><img src="photos/redflag.svg" alt="Logo"></button>
                        </div>
                        <button type="button" class="postBtn" id="postReview">POST</button>
                    </div>
                </div>

                <!-- DYNAMIC REVIEWS FROM DATABASE -->
                <div id="reviewsContainer">
                    <?php if (count($dbReviews) > 0): ?>
                        
                        <?php foreach ($dbReviews as $dbReview): ?>
                            <div class="review">
                                <h4><?= htmlspecialchars($dbReview['full_name']); ?></h4>
                                
                                <!-- SVG FLAGS -->
                                <p>
                                    <?php if ($dbReview['rating'] == 5): ?>
                                        <img src="photos/greenflag.svg" alt="Green Flag" style="height: 20px; width: auto; vertical-align: middle;">
                                        <span style="color: #28a745; font-weight: bold; vertical-align: middle; margin-left: 5px;">Green Flag</span>
                                    <?php else: ?>
                                        <img src="photos/redflag.svg" alt="Red Flag" style="height: 20px; width: auto; vertical-align: middle;">
                                        <span style="color: #dc3545; font-weight: bold; vertical-align: middle; margin-left: 5px;">Red Flag</span>
                                    <?php endif; ?>
                                </p>
                                
                                <p><?= nl2br(htmlspecialchars($dbReview['review'])); ?></p>
                                <small style="color: #888; font-size: 0.8rem;">
                                    <?= date("F j, Y", strtotime($dbReview['created_at'])); ?>
                                </small>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p style="text-align: center; color: #666; margin-top: 20px;">
                            No reviews yet. Be the first to share your experience!
                        </p>
                    <?php endif; ?>
                </div>
            </section>
        </main>
    </div> <!-- CLOSES .page-layout -->
    
    <!-- INJECT SESSION -->
    <script>
        window.userIsLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
        
        // Pass actual user's name to JavaScript
        window.userFullName = "<?php echo isset($_SESSION['full_name']) ? addslashes($_SESSION['full_name']) : 'You'; ?>";
        
        const urlParams = new URLSearchParams(window.location.search);
        window.dbSpotId = parseInt(urlParams.get("id")) || 1;
        window.currentSpotId = window.dbSpotId;
    </script>
    
    <script src="js/spots.js"></script>
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/search.js"></script>
    <script src="js/spot.js"></script>
    <script src="js/reviews.js?v=<?php echo time(); ?>"></script> <!-- Forces browser to load newest JS -->

</body>
</html>