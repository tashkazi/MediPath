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

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view medical history.";
    exit;
}


$user_id = $_SESSION['user_id'];

$sql_patient_id = "SELECT patient_id FROM users WHERE id = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);


if ($stmt_patient_id) {

    $stmt_patient_id->bind_param("i", $user_id);

    $stmt_patient_id->execute();

    $result_patient_id = $stmt_patient_id->get_result();


    if ($result_patient_id->num_rows > 0) {

        $row_patient_id = $result_patient_id->fetch_assoc();
        $patient_id = $row_patient_id['patient_id'];

        $sql_medical_history = "SELECT * FROM symptoms WHERE patient_id = ?";
        $stmt_medical_history = $conn->prepare($sql_medical_history);

        if ($stmt_medical_history) {

            $stmt_medical_history->bind_param("i", $patient_id);


            $stmt_medical_history->execute();


            $result_medical_history = $stmt_medical_history->get_result();

            if ($result_medical_history->num_rows > 0) {

                $medical_history = $result_medical_history->fetch_all(MYSQLI_ASSOC);


                echo json_encode($medical_history);
            } else {
                echo "No medical history found for the logged-in user.";
            }

            $stmt_medical_history->close();
        } else {
            echo "Error preparing SQL query for medical history: " . $conn->error;
        }
    } else {
        echo "Patient ID not found for the logged-in user.";
    }

    $stmt_patient_id->close();
} else {
    echo "Error preparing SQL query for patient ID: " . $conn->error;
}


$conn->close();



