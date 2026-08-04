<?php
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query(
        "SELECT s.id, s.name, s.location, s.description, s.image, s.hours, s.noise, s.privacy, s.price, s.created_at, t.id AS tag_id, t.tag_name
         FROM spots s
         LEFT JOIN spot_tags st ON st.spot_id = s.id
         LEFT JOIN tags t ON t.id = st.tag_id
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
