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
}
?>