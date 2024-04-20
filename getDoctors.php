<?php

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, first_name, last_name, specialization FROM providers";
$result = $conn->query($sql);

$providers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $providers[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($providers);

$conn->close();
