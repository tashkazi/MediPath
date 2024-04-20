<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
    $username = "doadmin";
    $password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
    $database = "medipath";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmtAdmins = $conn->prepare("DELETE FROM admins WHERE ID = ?");
    $stmtAdmins->bind_param("i", $id);
    $resultAdmins = $stmtAdmins->execute();

    $stmtPatients = $conn->prepare("DELETE FROM patients WHERE ID = ?");
    $stmtPatients->bind_param("i", $id);
    $resultPatients = $stmtPatients->execute();

    $stmtProviders = $conn->prepare("DELETE FROM providers WHERE ID = ?");
    $stmtProviders->bind_param("i", $id);
    $resultProviders = $stmtProviders->execute();

    if ($resultAdmins || $resultPatients || $resultProviders) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmtAdmins->close();
    $stmtPatients->close();
    $stmtProviders->close();
    $conn->close();
} else {
    echo 'ID parameter not set';
}

