<?php
session_start();

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com";
$port = 25060;
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to add a symptom.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT provider_id FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Provider not found.']);
    exit();
}

$provider_id = $result['provider_id'];

// Retrieve JSON data from the request
$json_data = file_get_contents('php://input');
$updatedProfileData = json_decode($json_data, true);

// Check if all required fields are present
$requiredFields = ['first_name', 'last_name', 'MINC', 'phone_number', 'address', 'email', 'dob', 'education', 'specialization', 'clinicAffiliation', 'experience', 'certifications', 'professionalMembership', 'image_url'];
foreach ($requiredFields as $field) {
    if (empty($updatedProfileData[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }
}

$first_name = $updatedProfileData['first_name'];
$last_name = $updatedProfileData['last_name'];
$MINC = $updatedProfileData['MINC'];
$phone_number = $updatedProfileData['phone_number'];
$address = $updatedProfileData['address'];
$email = $updatedProfileData['email'];
$dob = $updatedProfileData['dob'];
$education = $updatedProfileData['education'];
$specialization = $updatedProfileData['specialization'];
$clinicAffiliation = $updatedProfileData['clinicAffiliation'];
$experience = $updatedProfileData['experience'];
$certifications = $updatedProfileData['certifications'];
$professionalMembership = $updatedProfileData['professionalMembership'];
$image_url = $updatedProfileData['image_url'];

$stmt = $pdo->prepare("UPDATE providers SET first_name = ?, last_name = ?, MINC = ?, phone_number = ?, address = ?, email = ?, dob = ?, education = ?, specialization = ?, clinicAffiliation = ?, experience = ?, certifications = ?, professionalMembership = ?, image_url = ? WHERE id = ?");
$stmt->execute([$first_name, $last_name, $MINC, $phone_number, $address, $email, $dob, $education, $specialization, $clinicAffiliation, $experience, $certifications, $professionalMembership, $image_url, $provider_id]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to update profile.']);
}

$stmt->closeCursor();


