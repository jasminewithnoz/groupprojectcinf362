<?php
$searchTerm = strtolower(trim($_GET['search'] ?? ''));

$jsonData = file_get_contents('locations.json');
$destinations = json_decode($jsonData, true);

$filtered = [];

foreach ($destinations as $place) {
    if ($searchTerm === '' || strpos(strtolower($place['name']), $searchTerm) !== false) {
        $filtered[] = $place;
    }
}

echo json_encode($filtered);
?>
