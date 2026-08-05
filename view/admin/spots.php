<?php

// view/admin/spots.php

// 1. Authentication & DB connection
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once '../../model/process/spotmodel.php';

// 2. Set Page Title & Load Headers
$pageTitle = "Spots";
require_once 'includes/header.php';

// 3. Fetch Data via SpotModel
$result = getAllSpots($conn);
$availableTags = getAvailableTags($conn);
$spotTagMap = getSpotTagMap($conn);


/*
$query = "SELECT * FROM spots ORDER BY id ASC";
$result = mysqli_query($conn, $query);


$availableTags = [];
$tagsResult = mysqli_query($conn, "SELECT * FROM tags ORDER BY tag_name ASC");
while ($tagRow = mysqli_fetch_assoc($tagsResult)) {
    $availableTags[] = $tagRow;
}

$spotTagMap = [];
$spotTagsResult = mysqli_query($conn, "SELECT st.spot_id, t.id, t.tag_name FROM spot_tags st JOIN tags t ON t.id = st.tag_id ORDER BY st.spot_id, t.tag_name ASC");
while ($spotTagRow = mysqli_fetch_assoc($spotTagsResult)) {
    $spotTagMap[(int) $spotTagRow['spot_id']][] = $spotTagRow;
}
*/
?>

<div class="wrapper">
    <?php require_once "includes/sidebar.php"; ?>
    <div class="main">
        <?php require_once "includes/topbar.php"; ?>
        <div class="content">
            <?php if (isset($_GET['status'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php if ($_GET['status'] === 'created'): ?>
                        Spot created successfully.
                    <?php elseif ($_GET['status'] === 'updated'): ?>
                        Spot updated successfully.
                        <?php elseif ($_GET['status'] === 'deleted'): ?>
                        Spot deleted successfully. 
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'spot_exists'): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    <strong>Error:</strong> The spot already exists!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>


            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Spots Overview</h3>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSpotModal">
                    <i class="fa-solid fa-plus"></i> Add Spot
                </button>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Noise</th>
                                <th>Privacy</th>
                                <th>Price</th>
                                <th>Tags</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($spot = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= (int) $spot['id']; ?></td>
                                    <td><?= htmlspecialchars($spot['name']); ?></td>
                                    <td><?= htmlspecialchars($spot['location']); ?></td>
                                    <td><?= htmlspecialchars($spot['noise']); ?></td>
                                    <td><?= htmlspecialchars($spot['privacy']); ?></td>
                                    <td><?= htmlspecialchars($spot['price']); ?></td>
                                    <td>
                                        <?php if (!empty($spotTagMap[(int) $spot['id']])): ?>
                                            <?php foreach ($spotTagMap[(int) $spot['id']] as $spotTag): ?>
                                                <span class="badge bg-info-subtle text-info-emphasis me-1"><?= htmlspecialchars($spotTag['tag_name']); ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-muted">No tags</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-warning btn-sm editSpotBtn" data-id="<?= (int) $spot['id']; ?>">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <form method="POST" action="../../controller/admin/actions/spots/delete.php" class="d-inline">
                                                <input type="hidden" name="id" value="<?= (int) $spot['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this spot?');">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSpotModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/admin/actions/spots/add.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Spot</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                    <div class="mb-3"><label class="form-label">Location</label><input class="form-control" name="location" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description"></textarea></div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" accept="image/*">
                        <div class="form-text">Upload an image file for this spot; the file path will be stored in the database.</div>
                    </div>
                    <div class="mb-3"><label class="form-label">Hours</label><input class="form-control" name="hours"></div>
                    <div class="mb-3"><label class="form-label">Noise</label><select class="form-select" name="noise"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Privacy</label><select class="form-select" name="privacy"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Price</label><select class="form-select" name="price"><option>Free</option><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div class="border rounded p-2" style="max-height: 180px; overflow-y: auto;">
                            <?php if (!empty($availableTags)): ?>
                                <?php foreach ($availableTags as $tag): ?>
                                    <div class="form-check">
                                        <input class="form-check-input spot-tag-checkbox" type="checkbox" name="tag_ids[]" value="<?= (int) $tag['id']; ?>">
                                        <label class="form-check-label"><?= htmlspecialchars($tag['tag_name']); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted mb-0">No tags available yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Save Spot</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editSpotModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../controller/admin/actions/spots/edit.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Spot</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_spot_id">
                    <input type="hidden" name="existing_image" id="edit_spot_existing_image">
                    <div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" id="edit_spot_name" required></div>
                    <div class="mb-3"><label class="form-label">Location</label><input class="form-control" name="location" id="edit_spot_location" required></div>
                    <div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" id="edit_spot_description"></textarea></div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" id="edit_spot_image" accept="image/*">
                        <div id="edit_spot_image_hint" class="form-text text-muted">Current image: none</div>
                        <div class="form-text">Choose an image to replace the current spot image, or leave blank to keep the existing one.</div>
                    </div>
                    <div class="mb-3"><label class="form-label">Hours</label><input class="form-control" name="hours" id="edit_spot_hours"></div>
                    <div class="mb-3"><label class="form-label">Noise</label><select class="form-select" name="noise" id="edit_spot_noise"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Privacy</label><select class="form-select" name="privacy" id="edit_spot_privacy"><option>Low</option><option>Medium</option><option>High</option></select></div>
                    <div class="mb-3"><label class="form-label">Price</label><select class="form-select" name="price" id="edit_spot_price"><option>Free</option><option>Low</option><option>High</option></select></div>
                    <div class="mb-3">
                        <label class="form-label">Tags</label>
                        <div class="border rounded p-2" style="max-height: 180px; overflow-y: auto;">
                            <?php if (!empty($availableTags)): ?>
                                <?php foreach ($availableTags as $tag): ?>
                                    <div class="form-check">
                                        <input class="form-check-input spot-tag-checkbox" type="checkbox" name="tag_ids[]" value="<?= (int) $tag['id']; ?>">
                                        <label class="form-check-label"><?= htmlspecialchars($tag['tag_name']); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted mb-0">No tags available yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn btn-success" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once "includes/footer.php"; ?>
