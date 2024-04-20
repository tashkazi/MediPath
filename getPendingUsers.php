<?php

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM providers WHERE approved = 'pending'";
$result = $conn->query($sql);

$pendingProviders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pendingProviders[] = $row;
    }
}

$sql = "SELECT * FROM admins WHERE approved = 'pending'";
$result = $conn->query($sql);

$pendingAdmins = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pendingAdmins[] = $row;
    }
}

$pendingUsers = array_merge($pendingProviders, $pendingAdmins);

$conn->close();

header('Content-Type: application/json');
echo json_encode($pendingUsers);


