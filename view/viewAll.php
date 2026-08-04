<?php
// 1. Connect to the correct PDO database file (DISREGARD model/backend/config/database.php)
require_once (__DIR__ . '/../model/config/database.php');

$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// 2. Fetch main grid data
$query = "
    SELECT s.id, s.name, s.location, s.price, s.description, s.image,
           IFNULL(ROUND(AVG(r.rating), 1), 0) as avg_rating,
           COUNT(r.id) as review_count
    FROM spots s
    LEFT JOIN reviews r ON s.id = r.spot_id
    WHERE s.name LIKE ?
    GROUP BY s.id
    ORDER BY avg_rating DESC
";

$stmt = $pdo->prepare($query);
$searchWildcard = "%" . $searchTerm . "%";
$stmt->execute([$searchWildcard]);
$spots = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Fetch data for the live search dropdown
$allQuery = "SELECT id, name, location FROM spots";
$allStmt = $pdo->query($allQuery);
$allSpots = $allStmt->fetchAll(PDO::FETCH_ASSOC);

$priceMap = [
    'Free' => 'Free',
    'Low' => '$',
    'Medium' => '$$',
    'High' => '$$$'
];

// LOAD THE HEADER BEFORE CLOSING PHP
// This guarantees session_start() runs before any HTML comments
require_once __DIR__ . '/includes/header.php';
?>
    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->
    <main>
        <div class="popular">
            <section class="section-header">
                <h2><?php echo $searchTerm ? "Search Results for '" . htmlspecialchars($searchTerm) . "'" : "All Spots"; ?>
                </h2>
                <a href="index.php">Popular Now</a>
            </section>

            <div class="cards-container" style="flex-wrap: wrap;">
                <?php if (count($spots) > 0): ?>
                    <?php foreach ($spots as $spot): ?>
                        <!-- Removed the ($spot['id'] - 1) -->
                        <div class="card"
                            onclick="window.location.href='spot.php?id=<?php echo htmlspecialchars($spot['id']); ?>'">

                            <?php if (!empty($spot['image'])): ?>
                                <img src="<?php echo htmlspecialchars($spot['image']); ?>"
                                    alt="<?php echo htmlspecialchars($spot['name']); ?>">
                            <?php else: ?>
                                <!-- Swapped the gray box for the placeholder image! -->
                                <img src="photos/aaron_profile2.jpg" alt="Placeholder Image">
                            <?php endif; ?>

                            <div class="card-content">
                                <h3><?php echo htmlspecialchars($spot['name']); ?></h3>
                                <p class="location">📍 <?php echo htmlspecialchars($spot['location']); ?></p>

                                <div class="info">
                                    <span>⭐ <?php echo htmlspecialchars($spot['avg_rating']); ?>
                                        (<?php echo htmlspecialchars($spot['review_count']); ?>)</span>
                                    <span><?php echo $priceMap[$spot['price']]; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No spots found matching your search.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
        </div> <!-- CLOSES .page-layout -->

    <!-- Using the exact scripts from your index.php -->
    <script src="js/spots.js"></script>
    <script src="js/darkmode.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/search.js"></script>
</body>

</html>