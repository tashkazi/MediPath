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

$sqlAdmins = "SELECT * FROM admins";
$resultAdmins = mysqli_query($conn, $sqlAdmins);
$admins = array();
if (mysqli_num_rows($resultAdmins) > 0) {
    while ($row = mysqli_fetch_assoc($resultAdmins)) {
        $admins[] = $row;
    }
}

$sqlProviders = "SELECT * FROM providers";
$resultProviders = mysqli_query($conn, $sqlProviders);
$providers = array();
if (mysqli_num_rows($resultProviders) > 0) {
    while ($row = mysqli_fetch_assoc($resultProviders)) {
        $providers[] = $row;
    }
}

$sqlPatients = "SELECT * FROM patients";
$resultPatients = mysqli_query($conn, $sqlPatients);
$patients = array();
if (mysqli_num_rows($resultPatients) > 0) {
    while ($row = mysqli_fetch_assoc($resultPatients)) {
        $patients[] = $row;
    }
}

$usersData = array(
    'admins' => $admins,
    'providers' => $providers,
    'patients' => $patients
);

echo json_encode($usersData);

mysqli_close($conn);

