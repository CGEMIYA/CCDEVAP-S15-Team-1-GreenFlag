<?php
// bouncer
require_once 'includes/auth.php';

// Set page title
$pageTitle = "Analytics";

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<?php 
$pageTitle = 'Dashboard'; 
include 'includes/auth.php'; 
include 'includes/header.php'; 
require_once 'includes/db.php';

$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"));
$totalSpots = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM spots"));
$totalTags  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM tags"));
$totalReviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM reviews"));


$reviewStatus = [];
$reviewStatusQuery = mysqli_query($conn, "SELECT status, COUNT(*) AS count FROM reviews GROUP BY status");
while ($row = mysqli_fetch_assoc($reviewStatusQuery)) {
    $reviewStatus[$row['status']] = (int) $row['count'];
}

$userStatus = [];
$userStatusQuery = mysqli_query($conn, "SELECT status, COUNT(*) AS count FROM users GROUP BY status");
while ($row = mysqli_fetch_assoc($userStatusQuery)) {
    $userStatus[$row['status']] = (int) $row['count'];
}

$reviewLabels = [ 'approved', 'removed'];
$reviewData = [];
foreach ($reviewLabels as $label) {
    $reviewData[] = $reviewStatus[$label] ?? 0;
}
$userLabels = ['pending', 'verified', 'banned'];
$userData = [];
foreach ($userLabels as $label) {
    $userData[] = $userStatus[$label] ?? 0;
}
?> 

<div class="wrapper"> 
    <?php include 'includes/sidebar.php'; ?> 
    
    <div class="main"> 
        <?php include 'includes/topbar.php'; ?> 
        
        <div class="content"> 
            <div class="row g-4"> 
                <div class="col-lg-4 col-md-6"> 
                    <div class="card shadow-sm h-100"> 
                        <div class="card-body"> 
                            <h6 class="text-muted">Total Users</h6> 
                            <h2 class="mt-2"><?= (int) $totalUsers['count']; ?></h2> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4 col-md-6"> 
                    <div class="card shadow-sm h-100"> 
                        <div class="card-body"> 
                            <h6 class="text-muted">Total Spots</h6> 
                            <h2 class="mt-2"><?= (int) $totalSpots['count']; ?></h2> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4 col-md-6"> 
                    <div class="card shadow-sm h-100"> 
                        <div class="card-body"> 
                            <h6 class="text-muted">Total Tags</h6> 
                            <h2 class="mt-2"><?= (int) $totalTags['count']; ?></h2> 
                        </div> 
                    </div> 
                </div>
                <div class="col-lg-4 col-md-6"> 
                    <div class="card shadow-sm h-100"> 
                        <div class="card-body"> 
                            <h6 class="text-muted">Total Reviews</h6> 
                            <h2 class="mt-2"><?= (int) $totalReviews['count']; ?></h2> 
                        </div> 
                    </div> 
                </div>  
            </div> 
            
            <br> 
            
            <div class="row g-4"> 
                <div class="col-lg-8"> 
                    <div class="card shadow-sm"> 
                        <div class="card-header">Review Status</div> 
                        <div class="card-body"> 
                            <canvas id="reviewChart"></canvas> 
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4"> 
                    <div class="card shadow-sm"> 
                        <div class="card-header">User Status</div> 
                        <div class="card-body"> 
                            <canvas id="userChart"></canvas> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const reviewChart = new Chart(document.getElementById('reviewChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($reviewLabels) ?>,
            datasets: [{
                label: 'Reviews',
                data: <?= json_encode($reviewData) ?>,
                backgroundColor: [ '#2e7d32', '#b71c1c']
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    const userChart = new Chart(document.getElementById('userChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($userLabels) ?>,
            datasets: [{
                data: <?= json_encode($userData) ?>,
                backgroundColor: ['#f9a825', '#2e7d32', '#e53935', '#666666']
            }]
        },
        options: { responsive: true }
    });
</script>

<?php include 'includes/footer.php'; ?>
