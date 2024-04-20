<?php

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM providers WHERE approved = 'approved'";
$result = $conn->query($sql);

$activeProviders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activeProviders[] = $row;
    }
}
$sql = "SELECT * FROM admins WHERE approved = 'approved'";
$result = $conn->query($sql);

$activeAdmins = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activeAdmins[] = $row;
    }
}

$activeUsers = array_merge($activeProviders, $activeAdmins);

$conn->close();

header('Content-Type: application/json');
echo json_encode($activeUsers);

