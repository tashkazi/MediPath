<?php
session_start();

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_SESSION['admin_id'])) {
        die("You must be logged in as admin to add an appointment.");
    }

    $admin_id = $_SESSION['admin_id'];

    $provider_id = $_POST['providerId'];


    $patientId = $_POST['patientId'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];

    $startTime = strtotime($appointmentTime);
    $endTime = date('H:i:s', strtotime('+15 minutes', $startTime));

    if (!empty($provider_id) && !empty($patientId) && !empty($appointmentDate) && !empty($appointmentTime)) {

        $sql = "INSERT INTO appointments (provider_id, patient_id, appointment_date, start_time, end_time, status) 
                VALUES (?, ?, ?, ?, ?, 'Booked')";


        $stmt = $pdo->prepare($sql);
        $stmt->execute([$provider_id, $patientId, $appointmentDate, $appointmentTime, $endTime]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("error" => "Error saving appointment"));
        }
    } else {

        echo json_encode(array("error" => "All form fields are required."));
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

