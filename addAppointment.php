
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $servername = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
        $username = "doadmin";
        $password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
        $dbname = "medipath";


        $conn = new mysqli($servername, $username, $password, $dbname);


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $doctorName = $conn->real_escape_string($_POST['doctorName']);
        $appointmentDate = $conn->real_escape_string($_POST['appointmentDate']);
        $appointmentTime = $conn->real_escape_string($_POST['appointmentTime']);

        $query = "SELECT patient_id FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientId = $row['patient_id'];


            $providerId = getProviderIdFromName($doctorName, $conn);

            if ($providerId !== false) {

                $startTime = date('H:i:s', strtotime($appointmentTime));
                $endTime = date('H:i:s', strtotime($startTime . ' + 15 minutes'));
                $appointment_date = $appointmentDate;
                $start_time = '09:00:00';
                $iso_datetime = $appointment_date . 'T' . $start_time;


                $sql = "INSERT INTO appointments (provider_id, patient_id, appointment_date, start_time, end_time, status)
                        VALUES (?, ?, ?, ?, ?, 'Booked')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iisss", $providerId, $patientId, $appointmentDate, $startTime, $endTime);
                if ($stmt->execute()) {

                    $stmt->close();

                    $conn->close();

                    echo json_encode(array("success" => true, "message" => "Appointment saved successfully!"));
                    exit();
                } else {
                    echo json_encode(array("success" => false, "message" => "Error: Appointment booking failed!"));
                    exit();
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Error: Doctor's name not found!"));
                exit();
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Error: User not found!"));
            exit();
        }
    } else {

        header("Location: login.html");
        exit();
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid request method!"));
    exit();
}


function getProviderIdFromName($doctorName, $conn) {

    $sql = "SELECT id FROM providers WHERE CONCAT(first_name, ' ', last_name) = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $doctorName);
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id'];
    } else {
        return false;
    }
}
