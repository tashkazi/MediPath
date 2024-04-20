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

$sql = "SELECT `id`, `first_name`, `last_name`, `phn`, `phone_number`, `address`, `email`, `password`, `date_of_birth` FROM `patients`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $patients = [];
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($patients);
} else {
    echo json_encode(['error' => 'No patients found']);
}


if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "your_password";
    $dbname = "medipath";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$conn->close();}

