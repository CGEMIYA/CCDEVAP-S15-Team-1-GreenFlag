<?php
session_start();
require_once __DIR__ . '../config/database.php';

// Tell the browser to send JSON back, not HTML
header('Content-Type: application/json');

// Security Check: Are they logged in?
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized user.']);
    exit;
}

// 2. Grab the raw JSON data sent by JavaScript Fetch API
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['spot_id']) || empty($data['review']) || empty($data['rating'])) {
    echo json_encode(['success' => false, 'message' => 'Incomplete data provided.']);
    exit;
}

// Prepare variables
$userId = $_SESSION['user_id'];
$spotId = $data['spot_id'];
$reviewText = trim($data['review']);
$rating = $data['rating'];
$status = 'approved'; // Defaulting to approved based on your DB screenshot

// Insert into the database
try {
    $query = "INSERT INTO reviews (user_id, spot_id, rating, review, status, created_at, updated_at) 
              VALUES (:user_id, :spot_id, :rating, :review, :status, NOW(), NOW())";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':user_id' => $userId,
        ':spot_id' => $spotId,
        ':rating'  => $rating,
        ':review'  => $reviewText,
        ':status'  => $status
    ]);

    // Send success message to JS
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // If the database crashes, send the exact error back to JS for debugging
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>