<?php
session_start();

if (!isset($_SESSION['id'])) {
    $response = array('success' => false, 'message' => 'User not authenticated.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patientId = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phoneNumber'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("UPDATE patients SET first_name = ?, last_name = ?, email = ?, phone_number = ?, address = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $firstName, $lastName, $email, $phone, $address, $patientId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = array('success' => true, 'message' => 'Patient information updated successfully');
    } else {
        $response = array('success' => false, 'message' => 'Failed to update patient information');
    }

    header('Content-Type: application/json');
    echo json_encode($response);

    $stmt->close();
} else {

    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, phone_number, address FROM patients WHERE id = ?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    $patient = null;
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    }

    $response = array('patient' => $patient);

    header('Content-Type: application/json');
    echo json_encode($response);

    $stmt->close();
}

$conn->close();

