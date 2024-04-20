<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];

    $query = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM patients WHERE phn LIKE ?";
    $stmt = $conn->prepare($query);
    $phn_param = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $phn_param);
    $stmt->execute();
    $result = $stmt->get_result();

    $patients = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        echo json_encode($patients);
    } else {
        echo json_encode(array('error' => 'No patients found'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$stmt->close();
$conn->close();

