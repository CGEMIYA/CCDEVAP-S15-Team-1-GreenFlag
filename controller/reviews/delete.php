<?php
session_start();
require_once __DIR__ . '/../../model/config/database.php';
require_once __DIR__ . '/../../model/process/reviewmodel.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../view/myreviews.php");
    exit;
}

$reviewModel = new ReviewModel($pdo);
$reviewId = isset($_POST['review_id']) ? (int)$_POST['review_id'] : 0;
$userId = $_SESSION['user_id'];

if ($reviewId > 0) {
    $reviewModel->deleteReview($reviewId, $userId);
}

header("Location: ../../view/myreviews.php");
exit;