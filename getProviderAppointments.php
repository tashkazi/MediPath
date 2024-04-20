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
    echo "Please log in to view appointments.";
    exit;
}

$user_id = $_SESSION['user_id'];

$sql_provider_id = "SELECT provider_id FROM users WHERE id = ?";
$stmt_provider_id = $conn->prepare($sql_provider_id);


if ($stmt_provider_id) {

    $stmt_provider_id->bind_param("i", $user_id);

    $stmt_provider_id->execute();

    $result_provider_id = $stmt_provider_id->get_result();

    if ($result_provider_id->num_rows > 0) {

        $row_provider_id = $result_provider_id->fetch_assoc();
        $provider_id = $row_provider_id['provider_id'];

        $sqlAppointments = "SELECT appointments.*, patients.first_name, patients.last_name 
                            FROM appointments 
                            INNER JOIN patients ON appointments.patient_id = patients.id
                            WHERE provider_id = ?";
        $stmtAppointments = $conn->prepare($sqlAppointments);
        $stmtAppointments->bind_param("i", $provider_id);
        $stmtAppointments->execute();
        $resultAppointments = $stmtAppointments->get_result();

        $bookedAppointments = array();


        while ($rowAppointment = $resultAppointments->fetch_assoc()) {
            $startDateTime = $rowAppointment['appointment_date'] . 'T' . $rowAppointment['start_time'];
            $endDateTime = $rowAppointment['appointment_date'] . 'T' . $rowAppointment['end_time'];

            $bookedAppointments[] = array(
                'title' => 'Patient: ' . $rowAppointment['first_name'] . ' ' . $rowAppointment['last_name'],
                'start' => $startDateTime,
                'end' => $endDateTime
            );
        }


        $stmtAppointments->close();
        $conn->close();

        header('Content-Type: application/json');
        echo json_encode($bookedAppointments);
    } else {
        echo "Provider ID not found for the logged-in user.";
    }
} else {
    echo "Error preparing SQL statement: " . $conn->error;
}
