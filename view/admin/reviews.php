<?php
// view/admin/reviews.php

// 1. Authentication & DB connection
require_once 'includes/auth.php';
require_once '../../model/config/database.php';
require_once '../../model/process/reviewmodel.php';

// 2. Set Page Title & Load Headers
$pageTitle = "Reviews Moderation";
require_once 'includes/header.php';

// 3. Fetch Data via ReviewModel
$reviewModel = new ReviewModel($pdo);

$statusFilter = isset($_GET['filter']) ? $_GET['filter'] : null;
$reviews = $reviewModel->getAllReviewsForAdmin($statusFilter);
?>

<div class="wrapper">
    <?php require_once "includes/sidebar.php"; ?>
    <div class="main">
        <?php require_once "includes/topbar.php"; ?>
        <div class="content">
            
            <?php if (isset($_GET['status']) && $_GET['status'] === 'removed'): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    <strong>Success:</strong> Review has been removed and author notified.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    <strong>Error:</strong> 
                    <?php 
                        if ($_GET['error'] === 'custom_reason_required') {
                            echo "Please provide a custom explanation when selecting 'Other'.";
                        } else {
                            echo "Unable to complete moderation action.";
                        }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">Review Moderation</h3>
                    <p class="text-muted mb-0">Manage user reviews, enforce community guidelines, and view moderation history.</p>
                </div>
            </div>

            <!-- Filter Navigation Tabs -->
            <ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <a class="nav-link <?= (empty($statusFilter)) ? 'active bg-primary' : 'bg-light text-dark' ?>" href="reviews.php">
                        All Reviews
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link <?= ($statusFilter === 'approved') ? 'active bg-success' : 'bg-light text-dark' ?>" href="reviews.php?filter=approved">
                        Active Reviews
                    </a>
                </li>
                <li class="nav-item ms-2">
                    <a class="nav-link <?= ($statusFilter === 'removed') ? 'active bg-danger' : 'bg-light text-dark' ?>" href="reviews.php?filter=removed">
                        Removed by Admin
                    </a>
                </li>
            </ul>

            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Spot</th>
                                    <th>Rating</th>
                                    <th style="min-width: 250px;">Review Content</th>
                                    <th>Status</th>
                                    <th>Date Posted</th>
                                    <th width="150" class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($reviews) > 0): ?>
                                    <?php foreach ($reviews as $rev): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= (int)$rev['id']; ?></td>
                                            <td>
                                                <div class="fw-bold"><?= htmlspecialchars($rev['author_name']); ?></div>
                                                <small class="text-muted"><?= htmlspecialchars($rev['author_email']); ?></small>
                                            </td>
                                            <td>
                                                <a href="../spot.php?id=<?= (int)$rev['spot_id']; ?>" target="_blank" class="text-decoration-none fw-semibold">
                                                    <?= htmlspecialchars($rev['spot_name']); ?> <i class="fa-solid fa-arrow-up-right-from-square small ms-1"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <?php if ((int)$rev['rating'] === 5): ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                        <i class="fa-solid fa-flag me-1"></i> Green Flag
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                        <i class="fa-solid fa-flag me-1"></i> Red Flag
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="text-break" style="max-height: 80px; overflow-y: auto;">
                                                    <?= nl2br(htmlspecialchars($rev['review'])); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($rev['status'] === 'removed'): ?>
                                                    <span class="badge bg-danger text-white">
                                                        <i class="fa-solid fa-ban me-1"></i> Removed by Admin
                                                    </span>
                                                <?php elseif ($rev['status'] === 'approved'): ?>
                                                    <span class="badge bg-success text-white">
                                                        <i class="fa-solid fa-check me-1"></i> Active
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">
                                                        <?= ucfirst($rev['status']); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted"><?= date("M j, Y", strtotime($rev['created_at'])); ?></small>
                                            </td>
                                            <td class="text-end pe-3">
                                                <?php if ($rev['status'] !== 'removed'): ?>
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm openRemoveModalBtn" 
                                                            data-id="<?= (int)$rev['id']; ?>"
                                                            data-author="<?= htmlspecialchars($rev['author_name']); ?>"
                                                            data-spot="<?= htmlspecialchars($rev['spot_name']); ?>"
                                                            data-review="<?= htmlspecialchars($rev['review']); ?>">
                                                        <i class="fa-solid fa-shield-halved me-1"></i> Remove
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" 
                                                            class="btn btn-outline-secondary btn-sm viewAuditBtn"
                                                            data-id="<?= (int)$rev['id']; ?>"
                                                            data-reason="<?= htmlspecialchars($rev['removal_reason'] ?? 'N/A'); ?>"
                                                            data-custom="<?= htmlspecialchars($rev['removal_custom_reason'] ?? ''); ?>"
                                                            data-admin="<?= htmlspecialchars($rev['removed_by_admin_name'] ?? 'Administrator'); ?>"
                                                            data-date="<?= $rev['removed_at'] ? date("F j, Y, g:i A", strtotime($rev['removed_at'])) : 'N/A'; ?>">
                                                        <i class="fa-solid fa-circle-info me-1"></i> Audit Info
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                            No reviews found matching the current filter.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- REMOVAL MODAL (Requirement 2 & 3) -->
<div class="modal fade" id="removeReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="../../controller/admin/actions/reviews/remove.php" method="POST">
                <input type="hidden" name="review_id" id="modal_review_id">
                
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fa-solid fa-triangle-exclamation me-2"></i> Remove Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-4">
                    <!-- Confirmation Dialog Text (Requirement 2) -->
                    <div class="alert alert-warning border-warning d-flex align-items-start mb-3" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2 fs-5 flex-shrink-0 mt-1"></i>
                        <div>
                            Are you sure you want to remove this review? The review will no longer be publicly visible, and the author will be notified that it was removed for violating the community guidelines.
                        </div>
                    </div>

                    <!-- Review Context Summary -->
                    <div class="card bg-light border-0 mb-3">
                        <div class="card-body py-2 px-3 small">
                            <div><strong>Author:</strong> <span id="modal_author_name"></span></div>
                            <div><strong>Spot:</strong> <span id="modal_spot_name"></span></div>
                            <div class="mt-1 text-muted italic">"<span id="modal_review_text"></span>"</div>
                        </div>
                    </div>

                    <!-- Reason Selection (Requirement 3) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Removal Reason <span class="text-danger">*</span></label>
                        <select name="reason" id="modal_reason_select" class="form-select" required>
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

                    <div class="mb-3 d-none" id="custom_reason_container">
                        <label class="form-label fw-bold">Custom Explanation <span class="text-danger">*</span></label>
                        <textarea name="custom_reason" id="modal_custom_reason" class="form-control" rows="3" placeholder="Provide additional details regarding the guideline violation..."></textarea>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can me-1"></i> Confirm & Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AUDIT INFO MODAL (Requirement 8) -->
<div class="modal fade" id="auditInfoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title"><i class="fa-solid fa-clock-rotate-left me-2"></i> Moderation Audit Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="text-muted small d-block">Status</label>
                    <span class="badge bg-danger text-white fs-6"><i class="fa-solid fa-ban me-1"></i> Removed by Admin</span>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Moderator / Administrator</label>
                    <strong id="audit_admin_name"></strong>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Date & Time of Removal</label>
                    <span id="audit_removal_date"></span>
                </div>
                <div class="mb-3">
                    <label class="text-muted small d-block">Primary Reason</label>
                    <span id="audit_reason" class="badge bg-dark fs-6"></span>
                </div>
                <div class="mb-3 d-none" id="audit_custom_container">
                    <label class="text-muted small d-block">Custom Explanation</label>
                    <div id="audit_custom_text" class="p-2 bg-light border rounded text-dark"></div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const removeModal = new bootstrap.Modal(document.getElementById('removeReviewModal'));
    const auditModal = new bootstrap.Modal(document.getElementById('auditInfoModal'));
    const reasonSelect = document.getElementById('modal_reason_select');
    const customContainer = document.getElementById('custom_reason_container');
    const customInput = document.getElementById('modal_custom_reason');

    // Handle Reason dropdown change
    reasonSelect.addEventListener('change', function() {
        if (this.value === 'Other') {
            customContainer.classList.remove('d-none');
            customInput.setAttribute('required', 'required');
        } else {
            customContainer.classList.add('d-none');
            customInput.removeAttribute('required');
            customInput.value = '';
        }
    });

    // Open removal modal
    document.querySelectorAll('.openRemoveModalBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('modal_review_id').value = this.dataset.id;
            document.getElementById('modal_author_name').textContent = this.dataset.author;
            document.getElementById('modal_spot_name').textContent = this.dataset.spot;
            document.getElementById('modal_review_text').textContent = this.dataset.review;
            
            reasonSelect.value = '';
            customContainer.classList.add('d-none');
            customInput.value = '';
            
            removeModal.show();
        });
    });

    // Open audit info modal
    document.querySelectorAll('.viewAuditBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('audit_admin_name').textContent = this.dataset.admin;
            document.getElementById('audit_removal_date').textContent = this.dataset.date;
            document.getElementById('audit_reason').textContent = this.dataset.reason;

            const customText = this.dataset.custom;
            const auditCustomContainer = document.getElementById('audit_custom_container');
            if (customText && customText.trim() !== '') {
                document.getElementById('audit_custom_text').textContent = customText;
                auditCustomContainer.classList.remove('d-none');
            } else {
                auditCustomContainer.classList.add('d-none');
            }

            auditModal.show();
        });
    });
});
</script>

<?php require_once "includes/footer.php"; ?>