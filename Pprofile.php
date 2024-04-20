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

if (!isset($_SESSION['user_id']) || !isset($_SESSION['userType']) || $_SESSION['userType'] !== 'provider') {
    die("User not authenticated.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

} else {
    $stmt_provider = $conn->prepare("SELECT * FROM providers WHERE id = (SELECT provider_id FROM users WHERE id = ?)");
    $stmt_provider->bind_param("i", $user_id);
    $stmt_provider->execute();
    $result_provider = $stmt_provider->get_result();

    if ($result_provider->num_rows > 0) {
        $provider = $result_provider->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode(array('provider' => $provider));
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Failed to fetch provider information.'));
    }

    $stmt_provider->close();
}

$conn->close();

