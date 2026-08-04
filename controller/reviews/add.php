<?php
session_start();
require_once __DIR__ . '/../../model/config/database.php';
require_once __DIR__ . '/../../model/reviewmodel.php';

// Tell the browser we are sending JSON data back
header('Content-Type: application/json');

// Security Check
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$reviewModel = new ReviewModel($pdo);

// Grab data from the JavaScript POST request
$userId = $_SESSION['user_id'];
$spotId = isset($_POST['spot_id']) ? (int)$_POST['spot_id'] : 0;
$rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
$reviewText = trim($_POST['review_text'] ?? '');

// Validate and insert
if ($spotId > 0 && $rating > 0 && !empty($reviewText)) {
    
    $success = $reviewModel->addReview($userId, $spotId, $rating, $reviewText);
    
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database execution failed.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Please fill out all fields.']);
}