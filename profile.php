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

if (!isset($_SESSION['user_id']) || !isset($_SESSION['userType']) || $_SESSION['userType'] !== 'patient') {
    die("User not authenticated.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

} else {

    $stmt_user = $conn->prepare("SELECT patient_id FROM users WHERE id = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $patient_id = $row_user['patient_id'];

        // Use patient_id to fetch patient information from the patients table
        $stmt_patient = $conn->prepare("SELECT * FROM patients WHERE id = ?");
        $stmt_patient->bind_param("i", $patient_id);
        $stmt_patient->execute();
        $result_patient = $stmt_patient->get_result();

        if ($result_patient->num_rows > 0) {
            $patient = $result_patient->fetch_assoc();

            header('Content-Type: application/json');
            echo json_encode(array('patient' => $patient));
        } else {

            header('Content-Type: application/json');
            echo json_encode(array('error' => 'Failed to fetch patient information.'));
        }
    } else {

        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Failed to fetch patient information.'));
    }

    $stmt_user->close();
    $stmt_patient->close();
}

$conn->close();

