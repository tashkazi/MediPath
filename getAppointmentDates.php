<?php

$host = "medipath-do-user-16225435-0.c.db.ondigitalocean.com:25060";
$username = "doadmin";
$password = "AVNS_SSxCfBfPt-ZJbyCo3GE";
$database = "medipath";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['providerId']) && isset($_GET['selectedDate'])) {

    $providerId = intval($_GET['providerId']);
    $selectedDate = $_GET['selectedDate'];

    $sql = "SELECT start_time FROM appointments WHERE provider_id = ? AND appointment_date = ? AND status = 'Booked'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $providerId, $selectedDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookedTimeSlots = array();

    while ($row = $result->fetch_assoc()) {
        $bookedTimeSlots[] = $row['start_time'];
    }

    $stmt->close();

    $startTime = strtotime('09:00:00');
    $endTime = strtotime('18:00:00');
    $interval = 15 * 60;

    $availableTimeSlots = array();

    for ($time = $startTime; $time < $endTime; $time += $interval) {
        $currentTimeFormatted = date('H:i:s', $time);
        if (!in_array($currentTimeFormatted, $bookedTimeSlots)) {
            $availableTimeSlots[] = $currentTimeFormatted;
        }
    }

    echo json_encode($availableTimeSlots);
} else {
    echo json_encode(array('error' => 'Provider ID or selected date is missing'));
}

$conn->close();


