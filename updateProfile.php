<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['userType']) || $_SESSION['userType'] !== 'patient') {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT patient_id FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $patient_id = $row['patient_id'];
} else {

    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'User not found or multiple matches found.']);
    exit();
}

$requiredFields = ['first_name', 'last_name', 'phn', 'phone_number', 'address', 'email', 'dob'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phn = $_POST['phn'];
$phone_number = $_POST['phone_number'];
$address = $_POST['address'];
$email = $_POST['email'];
$dob = $_POST['dob'];

$stmt = $conn->prepare("UPDATE patients SET first_name = ?, last_name = ?, phn = ?, phone_number = ?, address = ?, email = ?, date_of_birth = ? WHERE id = ?");
$stmt->bind_param("sssssssi", $first_name, $last_name, $phn, $phone_number, $address, $email, $dob, $patient_id);

if ($stmt->execute()) {

    echo json_encode(['success' => true]);
} else {

    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update profile: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

