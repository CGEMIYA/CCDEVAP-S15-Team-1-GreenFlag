<?php
session_start();
require_once __DIR__ . '/../../model/config/database.php';
require_once __DIR__ . '/../../model/process/reviewmodel.php';

// Tell the browser we are sending JSON data back
header('Content-Type: application/json');

// Security Check
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$reviewModel = new ReviewModel($pdo);
$userId = $_SESSION['user_id'];

$payload = json_decode(file_get_contents('php://input'), true);
if (!is_array($payload)) {
    $payload = $_POST;
}

$spotId = isset($payload['spot_id']) ? (int)$payload['spot_id'] : 0;
$rating = isset($payload['rating']) ? (int)$payload['rating'] : 0;
$reviewText = trim($payload['review_text'] ?? $payload['review'] ?? '');

// Validate and insert
if ($spotId > 0 && $rating > 0 && !empty($reviewText)) {
    $success = $reviewModel->addReview($userId, $spotId, $rating, $reviewText);
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Review saved successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Unable to save review. Please try again later.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill out all fields and select a rating.']);
}