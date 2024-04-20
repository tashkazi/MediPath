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


        $sqlAppointments = "SELECT appointments.*, providers.first_name, providers.last_name 
                            FROM appointments 
                            INNER JOIN providers ON appointments.provider_id = providers.id
                            WHERE patient_id = ?";
        $stmtAppointments = $conn->prepare($sqlAppointments);
        $stmtAppointments->bind_param("i", $patient_id);
        $stmtAppointments->execute();
        $resultAppointments = $stmtAppointments->get_result();

        $bookedAppointments = array();
        while ($rowAppointment = $resultAppointments->fetch_assoc()) {

            $startDateTime = $rowAppointment['appointment_date'] . 'T' . $rowAppointment['start_time'];
            $endDateTime = $rowAppointment['appointment_date'] . 'T' . $rowAppointment['end_time'];

            $bookedAppointments[] = array(
                'title' => 'Dr. ' . $rowAppointment['first_name'] . ' ' . $rowAppointment['last_name'],
                'start' => $startDateTime,
                'end' => $endDateTime
            );
        }

        $stmtAppointments->close();
        $conn->close();

        header('Content-Type: application/json');
        echo json_encode($bookedAppointments);
    } else {
        echo "Patient ID not found for the logged-in user.";
    }
} else {
    echo "Error preparing SQL statement: " . $conn->error;
}

