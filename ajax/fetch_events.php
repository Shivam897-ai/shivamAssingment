<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

// Fetch all events from the database
$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the events as JSON
echo json_encode($events);
?>
