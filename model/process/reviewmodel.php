<?php
class ReviewModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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