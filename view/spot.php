    <?php 
        require_once __DIR__ . '/includes/header.php'; 
        require_once __DIR__ . '/../model/config/database.php';

        $spotId = isset($_GET['id']) ? (int)$_GET['id'] : 1;

        // Status check: only show approved reviews to public
        $stmt = $pdo->prepare("SELECT r.id AS review_id, r.rating, r.review, r.created_at, r.updated_at, u.full_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            WHERE r.spot_id = :spot_id AND r.status = 'approved' 
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
                            <!-- Added the ID anchor here! -->
                            <div class="review" id="review-<?= $dbReview['review_id']; ?>">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <h4><?= htmlspecialchars($dbReview['full_name']); ?></h4>
                                    
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                        <button type="button" class="btn-admin-remove" 
                                                style="background: #dc3545; color: white; border: none; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; cursor: pointer; display: inline-flex; align-items: center; gap: 5px;"
                                                onclick="openSpotAdminModeration(<?= $dbReview['review_id']; ?>, '<?= addslashes(htmlspecialchars($dbReview['full_name'])); ?>', '<?= addslashes(htmlspecialchars(trim(preg_replace('/\s+/', ' ', $dbReview['review'])))); ?>')">
                                            <i class="fa-solid fa-shield-halved"></i> Moderate Review
                                        </button>
                                    <?php endif; ?>
                                </div>
                                
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
                                    
                                    <!-- CHECK IF REVIEW HAS BEEN EDITED -->
                                    <?php if ($dbReview['created_at'] !== $dbReview['updated_at']): ?>
                                        <span style="font-style: italic; margin-left: 5px; cursor: help;" 
                                              title="Last edited: <?= date("F j, Y \a\\t g:i A", strtotime($dbReview['updated_at'])); ?>">
                                            (Edited)
                                        </span>
                                    <?php endif; ?>
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

    <!-- SPOT ADMIN MODERATION MODAL -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <div id="spotModOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 99999; justify-content: center; align-items: center;">
        <div style="background: var(--card-bg, #ffffff); color: var(--text-color, #333); width: 90%; max-width: 500px; padding: 25px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); font-family: inherit;">
            <h3 style="margin-top: 0; color: #dc3545; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-triangle-exclamation"></i> Moderate & Remove Review
            </h3>
            
            <!-- Requirement 2 Warning Text -->
            <div style="background: #fff3cd; color: #856404; padding: 12px; border-radius: 6px; font-size: 0.9rem; margin-bottom: 15px; border: 1px solid #ffeeba;">
                Are you sure you want to remove this review? The review will no longer be publicly visible, and the author will be notified that it was removed for violating the community guidelines.
            </div>

            <div style="background: #f8f9fa; color: #333; padding: 10px 12px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 15px; border: 1px solid #e9ecef;">
                <div><strong>Author:</strong> <span id="spotModAuthor"></span></div>
                <div style="margin-top: 4px; font-style: italic; color: #666;">"<span id="spotModReviewText"></span>"</div>
            </div>

            <form id="spotModForm">
                <input type="hidden" id="spotModReviewId" name="review_id">
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 5px;">
                        Select Removal Reason <span style="color: #dc3545;">*</span>
                    </label>
                    <select id="spotModReason" name="reason" required style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 0.9rem;">
                        <option value="" disabled selected>-- Select reason --</option>
                        <option value="Spam">Spam</option>
                        <option value="Offensive or abusive language">Offensive or abusive language</option>
                        <option value="Hate speech">Hate speech</option>
                        <option value="False or misleading information">False or misleading information</option>
                        <option value="Inappropriate content">Inappropriate content</option>
                        <option value="Duplicate review">Duplicate review</option>
                        <option value="Other">Other (custom explanation)</option>
                    </select>
                </div>

                <div id="spotModCustomContainer" style="display: none; margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 5px;">
                        Custom Explanation <span style="color: #dc3545;">*</span>
                    </label>
                    <textarea id="spotModCustomReason" name="custom_reason" rows="3" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid #ccc; font-size: 0.9rem;" placeholder="Provide additional details..."></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" onclick="closeSpotAdminModeration()" style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer;">Cancel</button>
                    <button type="submit" id="spotModSubmitBtn" style="background: #dc3545; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: bold;">Confirm & Remove</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openSpotAdminModeration(reviewId, authorName, reviewText) {
        document.getElementById('spotModReviewId').value = reviewId;
        document.getElementById('spotModAuthor').textContent = authorName;
        document.getElementById('spotModReviewText').textContent = reviewText;
        document.getElementById('spotModReason').value = '';
        document.getElementById('spotModCustomContainer').style.display = 'none';
        document.getElementById('spotModCustomReason').value = '';
        document.getElementById('spotModOverlay').style.display = 'flex';
    }

    function closeSpotAdminModeration() {
        document.getElementById('spotModOverlay').style.display = 'none';
    }

    document.getElementById('spotModReason').addEventListener('change', function() {
        if (this.value === 'Other') {
            document.getElementById('spotModCustomContainer').style.display = 'block';
            document.getElementById('spotModCustomReason').setAttribute('required', 'required');
        } else {
            document.getElementById('spotModCustomContainer').style.display = 'none';
            document.getElementById('spotModCustomReason').removeAttribute('required');
        }
    });

    document.getElementById('spotModForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const reviewId = document.getElementById('spotModReviewId').value;
        const reason = document.getElementById('spotModReason').value;
        const customReason = document.getElementById('spotModCustomReason').value;

        const btn = document.getElementById('spotModSubmitBtn');
        btn.disabled = true;
        btn.textContent = 'Removing...';

        try {
            const response = await fetch('../controller/admin/actions/reviews/remove.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    review_id: reviewId,
                    reason: reason,
                    custom_reason: customReason
                })
            });

            const result = await response.json();
            if (result.success) {
                closeSpotAdminModeration();
                const elem = document.getElementById('review-' + reviewId);
                if (elem) {
                    elem.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    elem.style.opacity = '0';
                    elem.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        elem.remove();
                        const container = document.getElementById('reviewsContainer');
                        if (container && container.children.length === 0) {
                            container.innerHTML = '<p style="text-align: center; color: #666; margin-top: 20px;">No reviews yet. Be the first to share your experience!</p>';
                        }
                    }, 400);
                }
                if (typeof notifySuccess === 'function') {
                    notifySuccess(result.message);
                } else {
                    alert(result.message);
                }
                // Refresh rating calculation
                if (typeof fetchSpotDetails === 'function') {
                    fetchSpotDetails();
                }
            } else {
                alert(result.message || 'Failed to remove review.');
            }
        } catch (err) {
            console.error(err);
            alert('A network error occurred while moderating review.');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Confirm & Remove';
        }
    });
    </script>
    <?php endif; ?>

    
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