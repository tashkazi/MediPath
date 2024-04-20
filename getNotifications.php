<?php
session_start();

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com";
$port = "25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to view notifications.");
    }

    // Check if the request is to mark notifications as read
    if (isset($_POST['closeDropdown'])) {
        // Mark notifications as read
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("UPDATE notifications SET read_status = 1 WHERE patient_id = (SELECT patient_id FROM users WHERE id = :user_id) AND read_status = 0");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    }

    // Fetch notifications
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT notification_message, timestamp, read_status FROM notifications WHERE patient_id = (SELECT patient_id FROM users WHERE id = :user_id) AND read_status = 0 ORDER BY timestamp DESC");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize variables
    $output = '';
    $unseen_notification = count($notifications);

    // Populate output with notifications
    if (!empty($notifications)) {
        foreach ($notifications as $row) {
            $notification_date = date('M j, Y', strtotime($row['timestamp']));
            $output .= '<div class="notification-item"><a href="#">'.$row["notification_message"].' (Symptoms added on '.$notification_date.')</a></div>';
        }
    } else {
        // If there are no unread notifications, return "No new notifications"
        $output = '<div class="notification-item">No new notifications</div>';
    }

    // Assuming this is the end of your PHP code
    echo json_encode(array(
        'unseen_notification' => $unseen_notification,
        'notifications' => $output
    ));

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
