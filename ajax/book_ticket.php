<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$event_id = intval($_POST['event_id']);
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT available_seats FROM events WHERE id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if ($event && $event['available_seats'] > 0) {
    $pdo->prepare("UPDATE events SET available_seats = available_seats - 1 WHERE id = ?")->execute([$event_id]);
    $pdo->prepare("INSERT INTO bookings (user_id, event_id) VALUES (?, ?)")->execute([$user_id, $event_id]);
    echo json_encode(['success' => 'Ticket booked successfully!']);
} else {
    echo json_encode(['error' => 'No seats available.']);
}
?>
