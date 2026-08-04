<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

try {
    // added a subquery (the second LEFT JOIN) to safely calculate reviews 
    $stmt = $pdo->query(
        "SELECT 
            s.id, s.name, s.location, s.description, s.image, 
            s.hours, s.noise, s.privacy, s.price, s.created_at, 
            t.id AS tag_id, t.tag_name,
            r.avg_rating, r.review_count
         FROM spots s
         LEFT JOIN spot_tags st ON st.spot_id = s.id
         LEFT JOIN tags t ON t.id = st.tag_id
         LEFT JOIN (
             SELECT spot_id, 
                    IFNULL(ROUND(AVG(rating), 1), 0) AS avg_rating, 
                    COUNT(id) AS review_count
             FROM reviews
             GROUP BY spot_id
         ) r ON s.id = r.spot_id
         ORDER BY s.id ASC, t.tag_name ASC"
    );

    $spotsById = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $spotId = (int) $row['id'];
        if (!isset($spotsById[$spotId])) {
            $spotsById[$spotId] = [
                'id' => $spotId,
                'name' => $row['name'],
                'location' => $row['location'],
                'description' => $row['description'],
                'image' => $row['image'],
                'hours' => $row['hours'],
                'noise' => $row['noise'],
                'privacy' => $row['privacy'],
                'price' => $row['price'],
                'created_at' => $row['created_at'],
                // Inject newly calculated math directly into the JSON
                'avg_rating' => $row['avg_rating'] ?? 0,
                'review_count' => $row['review_count'] ?? 0,
                'tags' => []
            ];
        }

        if (!empty($row['tag_id'])) {
            $spotsById[$spotId]['tags'][] = [
                'id' => (int) $row['tag_id'],
                'tag_name' => $row['tag_name']
            ];
        }
    }

    $spots = array_values($spotsById);

    echo json_encode($spots);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}