<?php
require_once __DIR__ . '/../model/config/database.php';
require_once __DIR__ . '/includes/header.php';

// Boot out logged out users
if (!isset($_SESSION['user_id'])) {
    echo "<main><div class='popular' style='text-align:center; padding:50px;'><h2>Please log in.</h2></div></main></div></body></html>";
    exit;
}

$userId = $_SESSION['user_id'];
$reviewId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// FETCH CURRENT REVIEW DATA (This stays in the View so we can populate the form!)
$stmt = $pdo->prepare("
    SELECT r.*, s.name AS spot_name, s.image AS spot_image 
    FROM reviews r 
    JOIN spots s ON r.spot_id = s.id 
    WHERE r.id = :id AND r.user_id = :user_id
");
$stmt->execute([':id' => $reviewId, ':user_id' => $userId]);
$reviewData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reviewData) {
    echo "<main><div class='popular' style='text-align:center; padding:50px;'><h2>Review not found or unauthorized.</h2><a href='myreviews.php'>Go Back</a></div></main></div></body></html>";
    exit;
}
?>

    <link rel="stylesheet" href="css/manage_review.css?version=<?php echo time(); ?>">

    <main>
        <div class="popular">
            <div class="manage-container">
                
                <!-- Top Banner -->
                <div class="manage-header-banner">
                    <img src="<?= !empty($reviewData['spot_image']) ? htmlspecialchars($reviewData['spot_image']) : 'photos/placeholder.jpg' ?>" 
                         alt="Spot Image" class="manage-banner-img">
                    <div class="manage-banner-text">
                        <p>EDITING REVIEW FOR</p>
                        <h2><?= htmlspecialchars($reviewData['spot_name']) ?></h2>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="manage-form-container">
                    
                    <!-- POINTS TO THE NEW EDIT CONTROLLER -->
                    <form method="POST" action="../controller/reviews/edit.php">
                        
                        <input type="hidden" name="review_id" value="<?= $reviewId ?>">

                        <div class="manage-form-group">
                            <label>Your Verdict</label>
                            
                            <div class="flag-options">
                                <label class="flag-radio">
                                    <input type="radio" name="rating" value="5" <?= ($reviewData['rating'] == 5) ? 'checked' : '' ?>>
                                    <img src="photos/greenflag.svg" alt="Green Flag">
                                    <span class="flag-green-text">Green Flag</span>
                                </label>

                                <label class="flag-radio">
                                    <input type="radio" name="rating" value="1" <?= ($reviewData['rating'] != 5) ? 'checked' : '' ?>>
                                    <img src="photos/redflag.svg" alt="Red Flag">
                                    <span class="flag-red-text">Red Flag</span>
                                </label>
                            </div>
                        </div>

                        <div class="manage-form-group">
                            <label>Review Text</label>
                            <textarea name="review_text" class="manage-textarea" required><?= htmlspecialchars($reviewData['review']) ?></textarea>
                        </div>

                        <div class="manage-controls">
                            <button type="button" class="btn-delete" onclick="if(confirm('Are you sure you want to permanently delete this review?')) { document.getElementById('delete-form').submit(); }">
                                🗑 Delete Review
                            </button>
                            
                            <div>
                                <a href="myreviews.php" class="btn-cancel">Cancel</a>
                                <button type="submit" class="btn-save">💾 Save Changes</button>
                            </div>
                        </div>
                    </form>

                    <!-- POINTS TO THE NEW DELETE CONTROLLER -->
                    <form id="delete-form" method="POST" action="../controller/reviews/delete.php" style="display: none;">
                        <input type="hidden" name="review_id" value="<?= $reviewId ?>">
                    </form>

                </div>
            </div>
        </div>
    </main>
    </div> <!-- CLOSES .page-layout -->
    
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
</body>
</html>