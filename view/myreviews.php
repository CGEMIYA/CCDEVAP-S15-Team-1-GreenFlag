<?php
require_once __DIR__ . '/../model/config/database.php';
require_once __DIR__ . '/includes/header.php';

// Boot out logged out users
if (!isset($_SESSION['user_id'])) {
    echo "<main><div class='history-empty-state' style='margin: 50px auto; max-width: 600px;'><h2>Please log in to view your reviews.</h2></div></main></div></body></html>";
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch their reviews AND join the spot details so we get the name, image, and removal metadata
$stmt = $pdo->prepare("
    SELECT 
        r.id AS review_id, 
        r.rating, 
        r.review, 
        r.status,
        r.removal_reason,
        r.removal_custom_reason,
        r.removed_at,
        r.created_at, 
        r.updated_at,
        s.id AS spot_id, 
        s.name AS spot_name, 
        s.image AS spot_image
    FROM reviews r
    JOIN spots s ON r.spot_id = s.id
    WHERE r.user_id = :user_id
    ORDER BY r.created_at DESC
");
$stmt->execute([':user_id' => $userId]);
$userReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <!-- LINK OUR NEW CSS FILE -->
    <link rel="stylesheet" href="css/myreviews.css">

    <main>
        <!-- ADDED THE "popular" WRAPPER TO GET THE BORDER/BACKGROUND -->
        <div class="popular">
            
            <section class="reviews-page-header">
                <h2>My Review History</h2>
            </section>

            <!-- Steam ahh styled container -->
            <div class="reviews-history-container">
                
                <?php if (count($userReviews) > 0): ?>
                    <?php foreach ($userReviews as $myReview): ?>
                        
                        <!-- Individual Review Card -->
                        <div class="history-review-card <?= ($myReview['status'] === 'removed') ? 'review-card-removed' : '' ?>">
                            
                            <!-- LEFT SIDE: Spot Thumbnail -->
                            <div class="history-spot-thumbnail">
                                <img src="<?= !empty($myReview['spot_image']) ? htmlspecialchars($myReview['spot_image']) : 'photos/placeholder.jpg' ?>" 
                                     alt="<?= htmlspecialchars($myReview['spot_name']) ?>">
                            </div>

                            <!-- RIGHT SIDE: Review Data & Controls -->
                            <div class="history-review-content">
                                
                                <div>
                                    <div class="history-title-row" style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                                        <h3 class="history-spot-title">
                                            <!-- Anchor Link to the specific review on the spot page -->
                                            <a href="spot.php?id=<?= $myReview['spot_id'] ?>" class="history-spot-link">
                                                <?= htmlspecialchars($myReview['spot_name']) ?>
                                            </a>
                                        </h3>

                                        <?php if ($myReview['status'] === 'removed'): ?>
                                            <span class="badge-removed-tag" style="background-color: #dc3545; color: #fff; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; display: inline-flex; align-items: center; gap: 5px;">
                                                <i class="fa-solid fa-ban"></i> Removed by Admin
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <p class="history-flag-container">
                                        <?php if ($myReview['rating'] == 5): ?>
                                            <img src="photos/greenflag.svg" alt="Green Flag" class="history-flag-icon">
                                            <span class="history-flag-text flag-green">Green Flag</span>
                                        <?php else: ?>
                                            <img src="photos/redflag.svg" alt="Red Flag" class="history-flag-icon">
                                            <span class="history-flag-text flag-red">Red Flag</span>
                                        <?php endif; ?>
                                    </p>

                                    <p class="history-review-text" style="<?= ($myReview['status'] === 'removed') ? 'text-decoration: line-through; opacity: 0.7;' : '' ?>">
                                        <?= nl2br(htmlspecialchars($myReview['review'])) ?>
                                    </p>

                                    <!-- Requirement 6: Removed Review Details Box -->
                                    <?php if ($myReview['status'] === 'removed'): ?>
                                        <div class="removed-reason-box" style="background-color: rgba(220, 53, 69, 0.1); border-left: 4px solid #dc3545; padding: 12px; border-radius: 4px; margin: 12px 0;">
                                            <p style="margin: 0 0 6px 0; color: #dc3545; font-weight: bold; font-size: 0.9rem;">
                                                <i class="fa-solid fa-triangle-exclamation"></i> Status: Removed by Admin
                                            </p>
                                            <p style="margin: 0 0 6px 0; font-size: 0.88rem;">
                                                <strong>Reason:</strong> <?= htmlspecialchars($myReview['removal_reason']) ?>
                                                <?php if (!empty($myReview['removal_custom_reason'])): ?>
                                                    - <em><?= htmlspecialchars($myReview['removal_custom_reason']) ?></em>
                                                <?php endif; ?>
                                            </p>
                                            <?php if (!empty($myReview['removed_at'])): ?>
                                                <p style="margin: 0 0 6px 0; font-size: 0.8rem; color: #777;">
                                                    <strong>Date Removed:</strong> <?= date("F j, Y \a\\t g:i A", strtotime($myReview['removed_at'])) ?>
                                                </p>
                                            <?php endif; ?>
                                            <p style="margin: 0; font-size: 0.85rem; font-style: italic; color: var(--text-color, #444);">
                                                "This review has been removed because it violated the community guidelines. It is no longer publicly visible."
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Bottom Row: Date & Buttons -->
                                <div class="history-review-footer">
                                    <small class="history-review-date">
                                        Posted <?= date("F j, Y", strtotime($myReview['created_at'])) ?>
                                        
                                        <!-- CHECK IF REVIEW HAS BEEN EDITED -->
                                        <?php if ($myReview['created_at'] !== $myReview['updated_at']): ?>
                                            <span style="font-style: italic; margin-left: 5px; cursor: help;" 
                                                  title="Last edited: <?= date("F j, Y \a\\t g:i A", strtotime($myReview['updated_at'])) ?>">
                                                (Edited)
                                            </span>
                                        <?php endif; ?>
                                    </small>
                                    
                                    <div class="review-controls">
                                        <a href="spot.php?id=<?= $myReview['spot_id'] ?>" class="btn-view-spot">
                                            View Spot
                                        </a>
                                        
                                        <?php if ($myReview['status'] !== 'removed'): ?>
                                            <!-- The Edit/Delete Button for Active Reviews -->
                                            <a href="manage_review.php?id=<?= $myReview['review_id'] ?>" class="btn-edit-review">
                                                Edit Review
                                            </a>
                                        <?php else: ?>
                                            <span style="font-size: 0.85rem; color: #dc3545; font-weight: 500; align-self: center;">
                                                <i class="fa-solid fa-circle-xmark"></i> Cannot edit removed review
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="history-empty-state">
                        <h3>You haven't reviewed any spots yet!</h3>
                        <p><a href="viewAll.php">Go find a spot to review.</a></p>
                    </div>
                <?php endif; ?>
                
            </div>
            
        </div> <!-- CLOSES .popular -->
    </main>
    </div> <!-- CLOSES .page-layout from header -->
    
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/spots.js"></script>
    <script src="js/search.js"></script>
</body>
</html>