<?php

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['userId'], $_POST['userType'])) {
        // Sanitize input
        $userId = filter_var($_POST['userId'], FILTER_SANITIZE_NUMBER_INT);
        $userType = $_POST['userType'];
        if ($userType !== 'admin' && $userType !== 'provider') {
            echo json_encode(['success' => false, 'error' => 'Invalid user type']);
            exit;
        }

        $sql = "UPDATE " . ($userType === 'admin' ? 'admins' : 'providers') . " SET approved = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'User approval status updated successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'User ID not found']);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to prepare SQL statement']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User ID or user type parameter is missing']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();

