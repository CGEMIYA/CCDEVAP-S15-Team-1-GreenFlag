<?php
session_start();
require_once __DIR__ . '/../../../../model/config/database.php';
require_once __DIR__ . '/../../../../model/process/reviewmodel.php';

// Ensure response format can handle both JSON (AJAX) and traditional form submits
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || 
          (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

// 1. Auth check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    if ($isAjax) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorized access. Admin role required.']);
    } else {
        header("Location: ../../../../view/admin/login.php");
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($isAjax) {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    } else {
        header("Location: ../../../../view/admin/reviews.php");
    }
    exit;
}

// 2. Parse input data (JSON or Form POST)
$rawInput = file_get_contents('php://input');
$jsonPayload = json_decode($rawInput, true);

if (is_array($jsonPayload)) {
    $reviewId = isset($jsonPayload['review_id']) ? (int)$jsonPayload['review_id'] : 0;
    $reason = trim($jsonPayload['reason'] ?? '');
    $customReason = trim($jsonPayload['custom_reason'] ?? '');
} else {
    $reviewId = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
    $reason = trim($_POST['reason'] ?? '');
    $customReason = trim($_POST['custom_reason'] ?? '');
}

// 3. Validation
$validReasons = [
    'Spam',
    'Offensive or abusive language',
    'Hate speech',
    'False or misleading information',
    'Inappropriate content',
    'Duplicate review',
    'Other'
];

if ($reviewId <= 0 || empty($reason) || !in_array($reason, $validReasons)) {
    if ($isAjax) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid review ID or removal reason provided.']);
    } else {
        header("Location: ../../../../view/admin/reviews.php?error=invalid_input");
    }
    exit;
}

if ($reason === 'Other' && empty($customReason)) {
    if ($isAjax) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Please provide a custom explanation when selecting "Other".']);
    } else {
        header("Location: ../../../../view/admin/reviews.php?error=custom_reason_required");
    }
    exit;
}

// 4. Perform soft delete & moderation logging
$adminId = (int)$_SESSION['user_id'];
$reviewModel = new ReviewModel($pdo);
$success = $reviewModel->removeReviewByAdmin($reviewId, $adminId, $reason, $customReason);

if ($success) {
    if ($isAjax) {
        echo json_encode(['success' => true, 'message' => 'Review successfully removed. User has been notified.']);
    } else {
        $redirectUrl = $_POST['redirect_url'] ?? '../../../../view/admin/reviews.php?status=removed';
        header("Location: " . $redirectUrl);
    }
} else {
    if ($isAjax) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to remove review or review not found.']);
    } else {
        header("Location: ../../../../view/admin/reviews.php?error=failed");
    }
}
exit;
?>
