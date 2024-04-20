<?php
session_start();

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['userType']) || $_SESSION['userType'] !== 'admin') {
    die("User not authenticated.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

} else {
    $stmt_user = $conn->prepare("SELECT admin_id FROM users WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $admin_id = $row_user['admin_id'];

        $stmt_admin = $conn->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt_admin->bind_param("i", $admin_id);
        $stmt_admin->execute();
        $result_admin = $stmt_admin->get_result();

        if ($result_admin->num_rows > 0) {
            $admin = $result_admin->fetch_assoc();

            header('Content-Type: application/json');
            echo json_encode(array('admin' => $admin));
        } else {

            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Failed to fetch admin information.'));
        }
    } else {

        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Failed to fetch admin information.'));
    }

    $stmt_user->close();
    $stmt_admin->close();
}

$conn->close();

