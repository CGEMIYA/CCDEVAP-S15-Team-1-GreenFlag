<?php
class ReviewModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // NEW: Insert a new review
    public function addReview($userId, $spotId, $rating, $reviewText) {
        $stmt = $this->pdo->prepare("
            INSERT INTO reviews (user_id, spot_id, rating, review, created_at, updated_at, status) 
            VALUES (:user_id, :spot_id, :rating, :review, NOW(), NOW(), 'approved')
        ");
        return $stmt->execute([
            ':user_id' => $userId,
            ':spot_id' => $spotId,
            ':rating' => $rating,
            ':review' => $reviewText
        ]);
    }

    public function updateReview($id, $userId, $text, $rating) {
        $stmt = $this->pdo->prepare("UPDATE reviews SET review = :review, rating = :rating, updated_at = NOW() WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':review' => $text,
            ':rating' => $rating,
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    public function deleteReview($id, $userId) {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':id' => $id,
            ':user_id' => $userId
        ]);
    }

    // Soft delete review by Admin and record audit trail & notification
    public function removeReviewByAdmin($reviewId, $adminId, $reason, $customReason = '') {
        // Fetch existing review and spot info
        $stmt = $this->pdo->prepare("
            SELECT r.*, s.name AS spot_name 
            FROM reviews r 
            JOIN spots s ON r.spot_id = s.id 
            WHERE r.id = :id
        ");
        $stmt->execute([':id' => $reviewId]);
        $review = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$review) {
            return false;
        }

        // 1. Soft delete by updating status & removal metadata
        $updateStmt = $this->pdo->prepare("
            UPDATE reviews 
            SET status = 'removed', 
                removal_reason = :reason, 
                removal_custom_reason = :custom_reason, 
                removed_by = :admin_id, 
                removed_at = NOW() 
            WHERE id = :id
        ");
        $success = $updateStmt->execute([
            ':reason' => $reason,
            ':custom_reason' => $customReason,
            ':admin_id' => $adminId,
            ':id' => $reviewId
        ]);

        if (!$success) {
            return false;
        }

        // 2. Insert into review_moderation_logs for Audit Trail
        $logStmt = $this->pdo->prepare("
            INSERT INTO review_moderation_logs (review_id, admin_id, reason, custom_reason, created_at) 
            VALUES (:review_id, :admin_id, :reason, :custom_reason, NOW())
        ");
        $logStmt->execute([
            ':review_id' => $reviewId,
            ':admin_id' => $adminId,
            ':reason' => $reason,
            ':custom_reason' => $customReason
        ]);

        // 3. Insert into general activity_logs
        $actStmt = $this->pdo->prepare("
            INSERT INTO activity_logs (user_id, action, description, created_at) 
            VALUES (:user_id, 'Removed Review', :description, NOW())
        ");
        $displayReason = ($reason === 'Other' && !empty($customReason)) ? "Other - {$customReason}" : $reason;
        $actStmt->execute([
            ':user_id' => $adminId,
            ':description' => "Admin #{$adminId} removed review #{$reviewId} for spot '{$review['spot_name']}'. Reason: {$displayReason}"
        ]);

        // 4. Create Notification for Review Author (Requirement 5)
        $notifMessage = "Your review for \"{$review['spot_name']}\" has been removed by an administrator because it violated the community guidelines. Reason: {$displayReason}. You may submit a new review that complies with the guidelines.";
        $notifStmt = $this->pdo->prepare("
            INSERT INTO notifications (user_id, review_id, type, message, created_at) 
            VALUES (:user_id, :review_id, 'review_removed', :message, NOW())
        ");
        $notifStmt->execute([
            ':user_id' => $review['user_id'],
            ':review_id' => $reviewId,
            ':message' => $notifMessage
        ]);

        return true;
    }

    // Get single review details
    public function getReviewById($reviewId) {
        $stmt = $this->pdo->prepare("
            SELECT r.*, u.full_name, u.email, s.name AS spot_name, s.image AS spot_image, admin_user.full_name AS removed_by_name
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            JOIN spots s ON r.spot_id = s.id 
            LEFT JOIN users admin_user ON r.removed_by = admin_user.id
            WHERE r.id = :id
        ");
        $stmt->execute([':id' => $reviewId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all reviews for Admin Moderation Dashboard with optional status filter
    public function getAllReviewsForAdmin($statusFilter = null) {
        $sql = "
            SELECT 
                r.id, r.user_id, r.spot_id, r.rating, r.review, r.status, r.removal_reason, r.removal_custom_reason, r.removed_at, r.created_at, r.updated_at,
                u.full_name AS author_name, u.email AS author_email,
                s.name AS spot_name,
                admin_user.full_name AS removed_by_admin_name
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            JOIN spots s ON r.spot_id = s.id
            LEFT JOIN users admin_user ON r.removed_by = admin_user.id
        ";

        if ($statusFilter && in_array($statusFilter, ['pending', 'approved', 'rejected', 'removed'])) {
            $sql .= " WHERE r.status = :status ";
        }

        $sql .= " ORDER BY r.id_at ASC";

        $stmt = $this->pdo->prepare($sql);
        if ($statusFilter && in_array($statusFilter, ['pending', 'approved', 'rejected', 'removed'])) {
            $stmt->execute([':status' => $statusFilter]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch unread notifications for a user
    public function getUnreadNotifications($userId) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM notifications 
            WHERE user_id = :user_id AND is_read = 0 
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mark notifications as read
    public function markNotificationsAsRead($userId) {
        $stmt = $this->pdo->prepare("
            UPDATE notifications SET is_read = 1 WHERE user_id = :user_id
        ");
        return $stmt->execute([':user_id' => $userId]);
    }
}
?>