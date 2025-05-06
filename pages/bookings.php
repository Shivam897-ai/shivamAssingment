<?php
session_start();
if (!isset($_SESSION['user_id']) or empty($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
}

require '../config/db.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT b.booking_time, e.name, e.event_date, e.venue 
                       FROM bookings b 
                       JOIN events e ON b.event_id = e.id 
                       WHERE b.user_id = ? 
                       ORDER BY b.booking_time DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
</head>
<body>
    <h2>Your Booking History</h2>
    <?php if (count($bookings) > 0): ?>
        <ul>
            <?php foreach ($bookings as $b): ?>
                <li>
                    <strong><?= htmlspecialchars($b['name']) ?></strong> |
                    <?= $b['event_date'] ?> @ <?= htmlspecialchars($b['venue']) ?> |
                    Booked on: <?= $b['booking_time'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No bookings yet.</p>
    <?php endif; ?>
    <p><a href="events.php">Back to Events</a> | <a href="../auth/logout.php">Logout</a></p>
</body>
</html>
