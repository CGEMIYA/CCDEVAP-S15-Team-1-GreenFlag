<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Boot out if not logged in
if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userId = $_SESSION['user_id'];

// PROCESS THE POST REQUEST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Grab the data from the hidden inputs
    $action = $_POST['action'] ?? '';
    $reviewId = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
    
    // ACTION: DELETE
    if ($action === 'delete' && $reviewId > 0) {
        // The user_id check ensures hackers can't delete other people's reviews
        $delStmt = $pdo->prepare("DELETE FROM reviews WHERE id = :id AND user_id = :user_id");
        $delStmt->execute([':id' => $reviewId, ':user_id' => $userId]);
        
        header("Location: ../../view/myreviews.php");
        exit;
    }
    
    // ACTION: UPDATE
    if ($action === 'update' && $reviewId > 0) {
        $newReviewText = trim($_POST['review_text']);
        $newRating = (int)$_POST['rating'];
        
        $updStmt = $pdo->prepare("UPDATE reviews SET review = :review, rating = :rating, updated_at = NOW() WHERE id = :id AND user_id = :user_id");
        $updStmt->execute([
            ':review' => $newReviewText,
            ':rating' => $newRating,
            ':id' => $reviewId,
            ':user_id' => $userId
        ]);
        
        header("Location: ../../view/myreviews.php");
        exit;
    }
}

// Fallback if someone tries to access this file directly without posting a form
header("Location: ../../view/myreviews.php");
exit;